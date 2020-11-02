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

    render() {
        return (
            <div>
                <FormAddItem hanldeAddListItem={this.handleAddListItem} itemId={this.state.items.length}></FormAddItem><br/>
                {this.state.displayItems ?
                    <ListItem listItems={this.state.items}></ListItem> : ""
                }
            </div>
        )
    }
}

export default ListCreator;