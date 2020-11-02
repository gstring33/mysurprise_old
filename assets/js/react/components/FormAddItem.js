import React, {Component} from 'react';

class FormAddItem extends Component {

    constructor(props) {
        super(props);
        this.state={
            id: '',
            title: '',
            description: '',
            link: ''
        }

        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
    }

    handleSubmit(event) {
        event.preventDefault();

        let item = {
            id: this.props.itemId,
            title: this.state.title,
            description: this.state.description,
            link: this.state.link
        }

        this.props.hanldeAddListItem(item);
    }

    handleChange(event) {
        const target = event.target
        const value = target.value
        const name = target.name

        this.setState({[name]: value})
    }

    render() {
        return <form onSubmit={this.handleSubmit}>
            <label htmlFor="title">Title</label>
            <input type="text" name="title" className="title" value={this.state.value} onChange={this.handleChange} />
            <label htmlFor="description">Description</label>
            <textarea name="description" className="description" value={this.state.value} onChange={this.handleChange} rows="4" cols="50"></textarea>
            <label htmlFor="link">Link</label>
            <input type="text" name="link" className="link" value={this.state.value} onChange={this.handleChange} />
            <input type="submit" value="Add Item"/>
        </form>;
    }
}

export default FormAddItem;