import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button';

import { Table } from '../../Common';
import { EditLink, AssignGroups } from './List';
import { convertObjectToArray, descendingSort } from '../../../Helper';
import {
  updateActiveUserInUserPage,
  updateActiveRightColInUserPage,
  updateActiveUserGroups
} from '../../../Redux/Actions';
import Config from '../../../Config';
import { fetchUserGroups } from '../../../Async';

const titles = [
  {
    label: 'Full Name',
    code: 'fullname'
  },
  {
    label: 'Country',
    code: 'country'
  },
  {
    label: 'Action',
    code: 'action'
  },
  {
    label: 'Groups',
    code: 'groups'
  }
];

class UserList extends React.Component {
  constructor(props) {
    super(props);
    this.updateUserPageStates = this.updateUserPageStates.bind(this);
    this.addNewUser = this.addNewUser.bind(this);
    this.handleUserSelection = this.handleUserSelection.bind(this);
  }

  updateUserPageStates(userId, column) {
    const {
      updateActiveUserInUserPage,
      updateActiveRightColInUserPage
    } = this.props;
    updateActiveUserInUserPage(userId);
    updateActiveRightColInUserPage(column);
  }

  /**
   * Fires when a user list item is clicked
   */
  handleUserSelection(userId) {
    const { updateActiveUserGroups } = this.props;
    if (userId) {
      this.updateUserPageStates(
        `item-${userId}`,
        Config.page.users.profileColumn
      );

      // collect user groups and update redux store
      fetchUserGroups(userId).then(userGroups => {
        updateActiveUserGroups(userGroups);
      });
    }
  }

  addNewUser() {
    // since it is a new user, we are setting active user state to null
    this.updateUserPageStates('', Config.page.users.createUserColumn);
  }

  render() {
    const { list, activeId } = this.props;
    const rows = list.map(user => {
      return {
        ...user,
        highlight: user.id === Number(activeId.replace('item-', '')),
        action: <EditLink userId={user.id} />,
        groups: <AssignGroups userId={user.id} />
      };
    });
    return (
      <Card className="mb-4">
        <Card.Header className="d-flex flex-wrap align-content-start border-bottom">
          <h6 className="m-0 pt-2">Users</h6>
          <Button type="button" className="ml-auto" onClick={this.addNewUser}>
            Add New User
          </Button>
        </Card.Header>
        <Card.Body className="p-0 pb-3">
          <Table
            titles={titles}
            rows={rows}
            rowClickHandler={this.handleUserSelection}
          />
        </Card.Body>
      </Card>
    );
  }
}

UserList.propTypes = {
  list: PropTypes.array.isRequired,
  activeId: PropTypes.string.isRequired,
  updateActiveUserInUserPage: PropTypes.func.isRequired,
  updateActiveRightColInUserPage: PropTypes.func.isRequired,
  updateActiveUserGroups: PropTypes.func.isRequired
};

const mapStateToProps = ({ users, page }) => ({
  list: descendingSort(convertObjectToArray(users.list)),
  activeId: page.users.activeUserId
});

const mapDispatchToProps = {
  updateActiveUserInUserPage,
  updateActiveRightColInUserPage,
  updateActiveUserGroups
};

UserList.displayName = 'UserList';

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(UserList);
