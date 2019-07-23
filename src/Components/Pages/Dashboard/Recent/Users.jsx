import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Card from 'react-bootstrap/Card';

import { Table } from '../../../Common';

const titles = [
  {
    label: 'Full Name',
    code: 'fullname'
  },
  {
    label: 'Country',
    code: 'country'
  }
];

function Users({ recentUsers }) {
  return (
    <Card className="mb-4">
      <Card.Header className="border-bottom">
        <h6 className="m-0">Recent Users</h6>
      </Card.Header>
      <Card.Body className="p-0 pb-3">
        <Table titles={titles} rows={recentUsers} />
      </Card.Body>
    </Card>
  );
}

Users.propTypes = {
  recentUsers: PropTypes.array.isRequired
};

const mapStateToProps = ({ users }) => ({
  recentUsers: Object.values(users.list) || []
});

Users.displayName = 'RecentUsers';

export default connect(mapStateToProps)(Users);
