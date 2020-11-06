import React, {Component} from 'react';
import FormAddItem from "./FormAddItem";
import ListItem from "./ListItem";

class ListCreator extends Component {

    constructor(props)
    {
        super(props);

        this.host = "http://localhost:8080";

        this.state = {
            items: [],
            alertMessage: false
        }

        this.handleRemoveItem = this.handleRemoveItem.bind(this);
        this.handleSendGiftData = this.handleSendGiftData.bind(this);
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
                    this.setState({items: items})
                }else {
                    this.setState({ alertMessage: data.message});
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

                        return {
                            items,
                            alertMessage: data.message,
                        };
                    });
                }else {
                    this.setState({ alertMessage: data.message});
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
            credentials: "same-origin",
        });

        return response;
    }

    getData(url)
    {
        const response = fetch(url, {
            method: "GET",
            cache:"no-cache",
            credentials: "same-origin",
        });

        return response;
    }

    render() {
        return (
            <div>
                <FormAddItem handleSendGiftData={this.handleSendGiftData}></FormAddItem><br/>
                {this.state.items.length > 0 ?
                    <ListItem listItems={this.state.items} handleRemoveItem={this.handleRemoveItem}></ListItem> : ""
                }
                {this.state.alertMessage ?
                    <p>{this.state.alertMessage}</p> : ""
                }
            </div>
        )
    }
}

export default ListCreator;