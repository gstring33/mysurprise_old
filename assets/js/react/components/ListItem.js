import React, {Component} from 'react';

class ListItem extends Component {

    render() {
        return <table>
            <thead>
                <tr>
                    <th>title</th>
                    <th>Description</th>
                    <th>link</th>
                </tr>
            </thead>
            <tbody>
            {this.props.listItems.map((item) =>(
                <tr key={'item-' + item.title + '-' + item.id}>
                    <td>{item.title}</td>
                    <td>{item.description}</td>
                    <td>{item.link}</td>
                </tr>
            ))}
            </tbody>
        </table>;
    }
}

export default ListItem;