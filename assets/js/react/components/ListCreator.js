import React, {Component} from 'react';
import FormAddItem from "./FormAddItem";
import ListItem from "./ListItem";

class ListCreator extends Component {

    constructor(props) {
        super(props);

        this.host = "http://localhost:8080";

        this.state = {
            items: [],
            displayItems: false
        }

        this.handleAddListItem = this.handleAddListItem.bind(this);
        this.handleRemoveItem = this.handleRemoveItem.bind(this);
        this.handleSendList=this.handleSendList.bind(this);
    }

    handleAddListItem(newItem) {
        this.setState(state => {
            const items = [...state.items, newItem];

            return {
                items,
                displayItems: true,
            };
        });
    }

    handleRemoveItem(itemId) {
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

    postData(url, data) {
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

    handleSendList()
    {
        this.postData(this.host + "/api/gift-list", this.state.items)
            .then(response => console.log(response.json()));
    }

    render() {
        return (
            <div>
                <FormAddItem hanldeAddListItem={this.handleAddListItem}></FormAddItem><br/>
                {this.state.displayItems ?
                    <ListItem listItems={this.state.items} handleRemoveItem={this.handleRemoveItem}></ListItem> : ""
                }
                {this .state.displayItems ?
                    <button onClick={this.handleSendList}>Send List</button>: ""
                }
            </div>
        )
    }
}

export default ListCreator;