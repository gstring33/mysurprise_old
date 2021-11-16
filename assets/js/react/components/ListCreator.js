import React, {Component, Fragment} from 'react';
import FormAddItem from "./FormAddItem";
import ListItem from "./ListItem";

class ListCreator extends Component {

    constructor(props)
    {
        super(props);

        this.host = process.env.LOCAL_HOST;

        this.state = {
            items: [],
            alertMessage: false
        }

        this.handleRemoveItem = this.handleRemoveItem.bind(this);
        this.handleSendGiftData = this.handleSendGiftData.bind(this);
        this.setAlertMessage = this.setAlertMessage.bind(this);
    }

    setAlertMessage(value) {
        this.setState({alertMessage: value})
    }

    componentDidMount()
    {
        const url = this.host + "/api/gifts";

        this.getData(url)
            .then(response => response.json())
            .then(data => {
                if(data.status === "success" && data.content.length > 0) {
                    const items = this.setState({items: data.content})
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    handleRemoveItem(itemId)
    {
        const id = parseInt(itemId)
        const url = this.host + "/api/gift/" + itemId;

        this.deleteData(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    const items = this.state.items;
                    items.splice(
                        items.findIndex(item => item.id === id),
                        1
                    )
                    this.setState({items: items, alertMessage: false})
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });

        if(this.state.items.length === 0) {
            this.setState({displayItems: false})
        }
    }

    handleSendGiftData(gift)
    {
        this.postData(this.host + "/api/gift", gift)
            .then(response => response.json())
            .then(data => {
                if(data.status === "success") {
                    this.setState(state => {
                        const items = [...state.items, data.content];

                        return { items, alertMessage: false };
                    });
                }else {
                    this.setAlertMessage({type: 'error', message: data.message});
                }

            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    postData(url, data)
    {
        const response = fetch(url , {
            method: "POST",
            cache:"no-cache",
            credentials: "same-origin",
            mode: 'no-cors',
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        return response;
    }

    deleteData(url)
    {
        const response = fetch(url , {
            method: "DELETE",
            cache:"no-cache",
            credentials: "same-origin"
        });

        return response;
    }

    getData(url)
    {
        const response = fetch(url, {
            method: "GET",
            cache:"no-cache",
            credentials: "same-origin",
            mode: 'no-cors'
        });

        return response;
    }

    render() {
        return (
            <React.Fragment>
                {this.state.alertMessage ?
                    <div className="alert alert-danger alert-dismissible fade show" role="alert">
                        {this.state.alertMessage.message}
                    </div> : ""
                }
                <div className="col-md-12">
                    <FormAddItem handleSendGiftData={this.handleSendGiftData} setAlertMessage={this.setAlertMessage}></FormAddItem>
                </div>
                <div className="col-md-12 mt-5">
                        {this.state.items.length > 0 ?
                           <ListItem listItems={this.state.items} handleRemoveItem={this.handleRemoveItem}></ListItem> : ""
                        }
                </div>
            </React.Fragment>
        )
    }
}

export default ListCreator;