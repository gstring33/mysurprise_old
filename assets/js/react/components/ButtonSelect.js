import React, {Component} from 'react';

class ButtonSelect extends Component {

    constructor(props) {
        super(props);
        this.handleOnSelect = this.handleOnSelect.bind(this)
    }

    getData() {

    }

    handleOnSelect() {
        const selection = this.getData();
        this.props.handleOnSelect(selection)
    }

    render() {
        return <button onClick={this.handleOnSelect}>TIRE AU SORT TON PARTENAIRE</button>
    }
}

export default ButtonSelect;