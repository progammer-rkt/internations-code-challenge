import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

import { PageTitle } from '../Components/Common';
import { DefaultLayout } from '../Components/Layout';
import { RecentUsers, RecentGroups } from '../Components/Pages/Dashboard';
import { updateUserList, updateGroupList } from '../Redux/Actions';
import { fetchUsers, fetchGroups } from '../Async';
import { convertArrayToObjects } from '../Helper';

class Dashboard extends React.Component {
  componentDidMount() {
    const limit = 5;
    const { updateUserList, updateGroupList } = this.props;
    // collect recent 5 users
    fetchUsers(limit).then(users => {
      // updating user list to the store
      if (users.length) {
        updateUserList(convertArrayToObjects(users));
      }
    });

    // collect recent 5 groups
    fetchGroups(limit).then(groups => {
      // updating group list to the store
      if (groups.length) {
        updateGroupList(convertArrayToObjects(groups));
      }
    });
  }

  render() {
    return (
      <DefaultLayout>
        <Container fluid className="main-content-container px-4">
          <Row noGutters className="page-header py-4">
            <PageTitle
              sm="4"
              title="Users & Groups"
              subtitle="Recent"
              className="text-sm-left"
            />
          </Row>
          <Row>
            <Col>
              <RecentUsers />
            </Col>
            <Col>
              <RecentGroups />
            </Col>
          </Row>
        </Container>
      </DefaultLayout>
    );
  }
}

Dashboard.propTypes = {
  updateUserList: PropTypes.func.isRequired,
  updateGroupList: PropTypes.func.isRequired
};

const mapDispatchToProps = {
  updateUserList,
  updateGroupList
};

Dashboard.displayName = 'DashboardPage';

export default connect(
  null,
  mapDispatchToProps
)(Dashboard);
