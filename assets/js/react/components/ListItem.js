import React, {Component} from 'react';

class ListItem extends Component {

    render() {
        console.log(this.props.listItems)
        return <table>
            <thead>
                <tr>
                    <th></th>
                    <th>title</th>
                    <th>Description</th>
                    <th>link</th>
                </tr>
            </thead>
            <tbody>
            {this.props.listItems.map((item) =>(
                <tr key={item.id}>
                    <td>{item.id}</td>
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