import React, {Component} from 'react';

class Selector extends Component {
    constructor(props) {
        super(props);
        this.host = "http://localhost:8080";
        this.handleOnSelect = this.handleOnSelect.bind(this)

        this.state = {selection: null}
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
        return <div>
            {this.state.selection === null ?
                <button onClick={this.handleOnSelect}>SELECT SOMEONE</button> :
                <div>
                    <p>Du hast {this.state.selection.firstname} gewählt</p>
                    <a href={this.state.selection.listPath}>List von {this.state.selection.firstname} ansehen </a>
                </div>
            }
        </div>
    }
}

export default Selector