import React, {Component} from 'react';

class Selector extends Component {
    constructor(props) {
        super(props);

        this.host = process.env.LOCAL_HOST;

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
        return <React.Fragment>
            {this.state.selection === null ?
                <button className="btn btn-primary btn-lg btn-block" onClick={this.handleOnSelect}>Tirer au sort</button> :
                <div className="card text-center mb-4 shadow-sm">
                    <img src={this.state.selection.image} className="card-img-top rounded-circle" alt={"select-" + this.state.selection.firstname}/>
                        <div className="card-body">
                            <p className="card-text card-teaser">Tu offriras ton cadeau à : <span className="card-teaser-name">{this.state.selection.firstname} !</span></p>
                            <a href="/" type="button" className="btn btn-secondary mb-2 ml-3"><i className="far fa-arrow-alt-circle-left fa-button"></i> Retour</a>
                        </div>
                </div>
            }
        </React.Fragment>;
    }
}

export default Selector