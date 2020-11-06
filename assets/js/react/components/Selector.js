import React, {Component} from 'react';

class Selector extends Component {
    constructor(props) {
        super(props);
        this.host = "http://localhost:8080";
        this.handleOnSelect = this.handleOnSelect.bind(this)
    }

    getData(url) {
        const response = fetch(url, {
            method: "GET",
            cache:"no-cache",
            credentials: "same-origin",
        });

        return response;
    }

    handleOnSelect() {
        const url = this.host + "/api/selection/"
        this.getData(url)
            .then(response => response.json())
            .then(data => {
                if(data.status === "success") {
                    this.setState({selection: data.content})
                }
            })
    }

    render() {
        return <button onClick={this.handleOnSelect}>SELECT SOMEONE</button>

    }
}

export default Selector