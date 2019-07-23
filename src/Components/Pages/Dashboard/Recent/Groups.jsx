import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Card from 'react-bootstrap/Card';

import { Table } from '../../../Common';

const titles = [
  {
    label: 'Name',
    code: 'name'
  }
];

function Groups({ recentGroups }) {
  return (
    <Card className="mb-4">
      <Card.Header className="border-bottom">
        <h6 className="m-0">Recent Groups</h6>
      </Card.Header>
      <Card.Body className="p-0 pb-3">
        <Table titles={titles} rows={recentGroups} />
      </Card.Body>
    </Card>
  );
}

Groups.propTypes = {
  recentGroups: PropTypes.array.isRequired
};

const mapStateToProps = ({ groups }) => ({
  recentGroups: Object.values(groups.list) || []
});

Groups.displayName = 'RecentUsers';

export default connect(mapStateToProps)(Groups);
