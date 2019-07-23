import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button';

import { Table } from '../../Common';
import EditLink from './List/EditLink';
import RemoveLink from './List/RemoveLink';
import {
  updateActiveGroupId,
  updateShowStatusOfCreateGroupForm
} from '../../../Redux/Actions';
import { ascendingSort } from '../../../Helper';

const titles = [
  {
    label: 'Name',
    code: 'name'
  },
  {
    label: 'Action',
    code: 'action'
  },
  {
    label: 'Remove',
    code: 'remove'
  }
];

class GroupList extends React.Component {
  constructor(props) {
    super(props);
    this.addNewUser = this.addNewUser.bind(this);
    this.hideCreateGroupForm = this.hideCreateGroupForm.bind(this);
  }

  addNewUser() {
    const {
      updateActiveGroupId,
      updateShowStatusOfCreateGroupForm
    } = this.props;
    updateActiveGroupId('');
    updateShowStatusOfCreateGroupForm(true);
  }

  hideCreateGroupForm() {
    const { updateShowStatusOfCreateGroupForm } = this.props;
    updateShowStatusOfCreateGroupForm(false);
  }

  render() {
    const { groups } = this.props;
    const rows = groups.map(group => {
      return {
        ...group,
        action: <EditLink groupId={group.id} />,
        remove: <RemoveLink groupId={group.id} />
      };
    });
    return (
      <Card className="mb-4">
        <Card.Header className="d-flex flex-wrap align-content-start border-bottom">
          <h6 className="m-0 pt-2">Recent Groups</h6>
          <Button type="button" className="ml-auto" onClick={this.addNewUser}>
            Add New Group
          </Button>
        </Card.Header>
        <Card.Body className="p-0 pb-3">
          <Table
            titles={titles}
            rows={rows}
            rowClickHandler={this.hideCreateGroupForm}
          />
        </Card.Body>
      </Card>
    );
  }
}
GroupList.propTypes = {
  groups: PropTypes.array.isRequired
};

const mapStateToProps = ({ groups }) => ({
  groups: ascendingSort(Object.values(groups.list) || [])
});

const mapDispatchToProps = {
  updateActiveGroupId,
  updateShowStatusOfCreateGroupForm
};

GroupList.displayName = 'RecentUsers';

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(GroupList);
