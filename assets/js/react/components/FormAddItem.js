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

        if(this.state.title === '') {
            return
        }

        let gift = {
            id: Math.floor(Math.random() * 1000000) + 1,
            title: this.state.title,
            description: this.state.description,
            link: this.state.link
        }
        this.resetForm();
        this.props.handleSendGiftData(gift);
    }

    handleChange(event) {
        const target = event.target
        const value = target.value
        const name = target.name

        this.setState({[name]: value})
    }

    resetForm() {
        this.setState({
            id: '',
            title: '',
            description: '',
            link: ''
        });
    }

    render() {
        return <form onSubmit={this.handleSubmit}>
            <label htmlFor="title">Title*</label><br/>
            <input type="text" name="title" className="title" value={this.state.title} onChange={this.handleChange} /><br/>
            <label htmlFor="description">Description</label><br/>
            <textarea name="description" className="description" value={this.state.description} onChange={this.handleChange} rows="4" cols="50"></textarea><br/>
            <label htmlFor="link">Link</label><br/>
            <input type="text" placeholder="ex: https://amazon.de" name="link" className="link" value={this.state.link} onChange={this.handleChange} /><br/>
            <input type="submit" value="Add Item"/>
        </form>;
    }
}

export default FormAddItem;