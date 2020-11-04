import React, {Component} from 'react';

class ListItem extends Component {

    constructor(props) {
        super(props);

        this.handleRemoveItem = this.handleRemoveItem.bind(this)
    }

    handleRemoveItem(event) {
        const ItemId = event.target.dataset.id
        this.props.handleRemoveItem(ItemId)
    }

    render() {
        return <table>
            <thead>
                <tr>
                    <th>title</th>
                    <th>Description</th>
                    <th>link</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {this.props.listItems.map((item) =>(
                <tr key={'item-' + item.id}>
                    <td>{item.title}</td>
                    <td>{item.description}</td>
                    <td>{item.link}</td>
                    <td><button type="button" data-id={item.id} onClick={this.handleRemoveItem}>X</button></td>
                </tr>
            ))}
            </tbody>
        </table>;
    }
}

export default ListItem;