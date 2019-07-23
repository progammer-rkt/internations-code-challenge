import React from 'react';
import PropTypes from 'prop-types';

class Trows extends React.Component {
  constructor(props) {
    super(props);
    this.tableRowClick = this.tableRowClick.bind(this);
  }

  /**
   * Collecting row id from the HTML Element and pass to the parent
   */
  tableRowClick(htmlElemRef) {
    const { clickHandler } = this.props;
    const rowElemId = htmlElemRef.currentTarget.id;

    if (rowElemId) {
      clickHandler(rowElemId.split('-').pop());
    }
  }

  render() {
    const { rows, titles } = this.props;
    return rows.map((row, index) => {
      const rowContent = [];
      rowContent.push(index + 1);
      titles.forEach(title => {
        rowContent.push(row[title.code] || '');
      });

      const tds = rowContent.map((rc, j) => <td key={j.toString()}>{rc}</td>);
      const className = row.highlight ? 'table-row-highlight' : '';
      return (
        <tr
          id={`row-${row.id}`}
          onClick={this.tableRowClick}
          className={className}
          key={row.id}
        >
          {tds}
        </tr>
      );
    });
  }
}

Trows.propTypes = {
  titles: PropTypes.array,
  rows: PropTypes.array,
  clickHandler: PropTypes.func
};

Trows.defaultProps = {
  titles: [],
  rows: [],
  clickHandler: () => {}
};

export default Trows;
