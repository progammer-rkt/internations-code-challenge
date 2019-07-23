import React from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

import { PageTitle, PageMessage } from '../Components/Common';
import { DefaultLayout } from '../Components/Layout';
import {
  UserList,
  CreateUser,
  Profile,
  AssignGroups
} from '../Components/Pages/Users';
import { fetchUsers, fetchGroups } from '../Async';
import {
  updateUserList,
  updateActiveUserInUserPage,
  updateGroupList
} from '../Redux/Actions';
import { convertArrayToObjects } from '../Helper';
import Config from '../Config';

class Users extends React.Component {
  constructor(props) {
    super(props);
    this.rightColumnContent = this.rightColumnContent.bind(this);
  }

  componentDidMount() {
    const {
      updateUserList,
      updateActiveUserInUserPage,
      updateGroupList
    } = this.props;
    // collect users list
    fetchUsers()
      .then(users => {
        // updating user list to the store
        if (users.length) {
          const usersObj = convertArrayToObjects(users);
          updateUserList(usersObj);
          return usersObj;
        }
        return {};
      })
      .then(users => {
        // make first user in the list as the active user
        if (Object.keys(users).length > 0) {
          updateActiveUserInUserPage(Object.keys(users)[0]);
        }
      });

    // collect groups
    fetchGroups().then(groups => {
      // updating group list to the store
      if (groups.length) {
        updateGroupList(convertArrayToObjects(groups));
      }
    });
  }

  rightColumnContent() {
    const { activeRightCol } = this.props;
    const { assignGroupsColumn, createUserColumn } = Config.page.users;
    if (activeRightCol === assignGroupsColumn) {
      return <AssignGroups />;
    }
    if (activeRightCol === createUserColumn) {
      return <CreateUser />;
    }
    return <Profile />;
  }

  render() {
    return (
      <DefaultLayout>
        <Container fluid className="main-content-container px-4">
          <Row noGutters className="page-header py-4">
            <PageTitle
              sm="4"
              title="User Management"
              subtitle="Users"
              className="text-sm-left"
            />
          </Row>
          <Row>
            <PageMessage />
          </Row>
          <Row>
            <Col md={8}>
              <UserList />
            </Col>
            <Col md={4}>{this.rightColumnContent()}</Col>
          </Row>
        </Container>
      </DefaultLayout>
    );
  }
}

Users.propTypes = {
  activeRightCol: PropTypes.string.isRequired,
  updateUserList: PropTypes.func.isRequired,
  updateActiveUserInUserPage: PropTypes.func.isRequired,
  updateGroupList: PropTypes.func.isRequired
};

const mapStateToProps = ({ page }) => ({
  activeRightCol: page.users.activeRightCol
});

const mapDispatchToProps = {
  updateUserList,
  updateActiveUserInUserPage,
  updateGroupList
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Users);
