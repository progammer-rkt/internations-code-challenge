import React from 'react';
import PropTypes from 'prop-types';
import BootstrapTable from 'react-bootstrap/Table';

import Trows from './Table/Trows';

function Theads({ titles }) {
  return titles.map(title => {
    return (
      <th key={title.code} scope="col" className="border-0">
        {title.label}
      </th>
    );
  });
}

function Table({ titles, rows, rowClickHandler }) {
  if (titles.length > 0 && rows.length > 0) {
    return (
      <BootstrapTable hover className="table mb-0">
        <thead className="bg-light">
          <tr>
            <th scope="col" className="border-0">
              #
            </th>
            <Theads titles={titles} />
          </tr>
        </thead>
        <tbody>
          <Trows titles={titles} rows={rows} clickHandler={rowClickHandler} />
        </tbody>
      </BootstrapTable>
    );
  }
  return <React.Fragment />;
}

Table.propTypes = {
  titles: PropTypes.array,
  rows: PropTypes.array,
  rowClickHandler: PropTypes.func,
};

Table.defaultProps = {
  titles: [],
  rows: [],
  rowClickHandler: () => {},
};

Table.displayName = 'Table';

export default Table;
