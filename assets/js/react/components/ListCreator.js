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



    handleRemoveItem(itemId)
    {
        const id = parseInt(itemId)
        const items = this.state.items;
        items.splice(
            items.findIndex(item => item.id === id),
            1
        )

        this.setState({items: items})

        if(this.state.items.length === 0) {
            this.setState({displayItems: false})
        }
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

    handleSendGiftData(gift)
    {
        this.postData(this.host + "/api/gift-list", gift)
            .then(response => response.json())
            .then(data => {
                if(data.status === "success") {
                    this.setState(state => {
                        const items = [...state.items, gift];

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