import React, {Component} from 'react';
import FormAddItem from "./FormAddItem";
import ListItem from "./ListItem";

class ListCreator extends Component {

    constructor(props) {
        super(props);

        this.state = {
            items: [],
            displayItems: false
        }

        this.handleAddListItem = this.handleAddListItem.bind(this);
        this.handleRemoveItem = this.handleRemoveItem.bind(this)
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

    render() {
        return (
            <div>
                <FormAddItem hanldeAddListItem={this.handleAddListItem}></FormAddItem><br/>
                {this.state.displayItems ?
                    <ListItem listItems={this.state.items} handleRemoveItem={this.handleRemoveItem}></ListItem> : ""
                }
            </div>
        )
    }
}

export default ListCreator;