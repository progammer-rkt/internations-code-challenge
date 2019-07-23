import React from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

import { PageTitle, PageMessage } from '../Components/Common';
import { DefaultLayout } from '../Components/Layout';
import { GroupList, CreateGroup } from '../Components/Pages/Groups';
import { fetchGroups } from '../Async';
import { updateGroupList } from '../Redux/Actions';
import { convertArrayToObjects } from '../Helper';

class Groups extends React.Component {
  componentDidMount() {
    const { updateGroupList } = this.props;

    // collect groups
    fetchGroups().then(groups => {
      // updating group list to the store
      if (groups.length) {
        updateGroupList(convertArrayToObjects(groups));
      }
    });
  }

  render() {
    const { showGroupForm } = this.props;
    return (
      <DefaultLayout>
        <Container fluid className="main-content-container px-4">
          <Row noGutters className="page-header py-4">
            <PageTitle
              sm="4"
              title="Groups Management"
              subtitle="Groups"
              className="text-sm-left"
            />
          </Row>
          <Row>
            <PageMessage />
          </Row>
          <Row>
            <Col md={8}>
              <GroupList />
            </Col>
            <Col md={4}>
              {showGroupForm ? <CreateGroup /> : <React.Fragment />}
            </Col>
          </Row>
        </Container>
      </DefaultLayout>
    );
  }
}

Groups.propTypes = {
  updateGroupList: PropTypes.func.isRequired
};

const mapStateToProps = ({ groups, page }) => ({
  activeGroupId: !!groups.activeGroupId,
  showGroupForm: page.groups.showGroupForm
});

const mapDispatchToProps = {
  updateGroupList
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Groups);
