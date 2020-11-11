import React, {Component} from 'react';

class ListItem extends Component {

    constructor(props) {
        super(props);

        this.handleRemoveItem = this.handleRemoveItem.bind(this)
    }

    handleRemoveItem(event) {
        event.preventDefault();
        const ItemId = event.target.dataset.id
        this.props.handleRemoveItem(ItemId)
    }

    render() {
        return (
            <table className="table">
                <thead className="thead-dark">
                <tr>
                    <th scope="col" className="col-width-25">Titel</th>
                    <th scope="col" className="col-width-70">Beschreibung</th>
                    <th scope="col" className="col-width-25">Link</th>
                    <th scope="col"className="col-width-10">Aktion</th>
                </tr>
                </thead>
                <tbody>
                {this.props.listItems.map((item) =>(
                    <tr key={'item-' + item.id}>
                        <td>{item.title}</td>
                        <td>{item.description}</td>
                        <td>{item.link}</td>
                        <td><i className="fa fa-trash" aria-hidden="true" data-id={item.id} onClick={this.handleRemoveItem}></i></td>
                    </tr>
                ))}
                </tbody>
            </table>
        );
    }
}

export default ListItem;