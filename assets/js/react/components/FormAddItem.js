import React, {Component} from 'react';

class FormAddItem extends Component {

    constructor(props) {
        super(props);

        this.handleAddListItem = this.handleAddListItem.bind(this);
    }

    handleAddListItem(event) {
        event.preventDefault();

        let item = {
            id: 1,
            title: 'Title 1',
            description: 'Lorem ipsum',
            link: 'www.google.com'
        }

        this.props.hanldeAddListItem(item);
    }

    render() {
        return <form onSubmit={this.handleAddListItem}>
            <label htmlFor="title">Title</label>
            <input type="text" className="title" name="title"/>
            <label htmlFor="description">Description</label>
            <textarea className="description" rows="4" cols="50"></textarea>
            <label htmlFor="link">Link</label>
            <input type="text" className="link"/>
            <button type="submit" value="Submit">Add Item</button>
        </form>;
    }
}

export default FormAddItem;