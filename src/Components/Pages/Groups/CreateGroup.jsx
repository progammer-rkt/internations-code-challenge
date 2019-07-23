import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Card from 'react-bootstrap/Card';
import Col from 'react-bootstrap/Col';
import Form from 'react-bootstrap/Form';
import FormGroup from 'react-bootstrap/FormGroup';
import Button from 'react-bootstrap/Button';
import {
  addPageErrorMessage,
  triggerLoader,
  addNewGroupToList,
  addPageSuccessMessage,
  updateGroupDetailsInList
} from '../../../Redux/Actions';
import { updateGroup, createGroup } from '../../../Async';

const initialState = {
  name: '',
  country: '',
  isTouched: {
    name: false
  }
};

class CreateUser extends React.Component {
  constructor(props) {
    super(props);
    this.state = { ...initialState };
    this.onInputChange = this.onInputChange.bind(this);
    this.submitForm = this.submitForm.bind(this);
    this.requestCatch = this.requestCatch.bind(this);
  }

  /**
   * When create form is present and is edited, then we click on the
   * add new group button, the form is not clearing. This is due to the
   * component's isTouched state is not reset. We are enforcing whenever
   * a add new group button is clicked.
   */
  componentDidUpdate(oldProps) {
    const { isNewGroup: oldIsNewUser } = oldProps;
    const { isNewGroup: newIsNewUser } = this.props;

    if (oldIsNewUser !== newIsNewUser) {
      this.setState({ ...initialState });
    }
  }

  onInputChange(event) {
    const { isTouched } = this.state;
    const inpTarget = event.target.name;
    const inpValue = event.target.value;
    this.setState({ [inpTarget]: inpValue });

    if (!isTouched[inpTarget]) {
      this.setState({
        isTouched: {
          ...isTouched,
          [inpTarget]: true
        }
      });
    }
  }

  requestCatch() {
    const { triggerLoader, addPageErrorMessage } = this.props;
    triggerLoader(false);
    addPageErrorMessage('Ohhoo.. something gone wrong. Please try later.');
  }

  submitForm() {
    const { name, country, isTouched } = this.state;
    const {
      isNewGroup,
      group,
      addPageErrorMessage,
      triggerLoader,
      addPageSuccessMessage,
      addNewGroupToList,
      updateGroupDetailsInList
    } = this.props;

    // make sure form is touched
    if (!Object.keys(isTouched).find(field => isTouched[field] === true)) {
      addPageErrorMessage('There is no change in the form; Sorry');
      return;
    }

    // make sure there is name exist
    if (!name) {
      addPageErrorMessage('Name field cannot be empty; Sorry');
      return;
    }

    triggerLoader(true);

    if (isNewGroup) {
      createGroup({ name, country })
        .then(newGroup => {
          addNewGroupToList({ ...newGroup });

          triggerLoader(false);
          addPageSuccessMessage('Group created successfully');
        })
        .catch(this.requestCatch);
    } else {
      const data = {
        id: group.id,
        name: name === '' ? group.name : name
      };
      updateGroup(data)
        .then(updatedGroup => {
          updateGroupDetailsInList({ ...updatedGroup });
          triggerLoader(false);
          addPageSuccessMessage('Group details edited successfully');
        })
        .catch(this.requestCatch);
    }
  }

  render() {
    const { name, isTouched } = this.state;
    const { isNewGroup, group } = this.props;
    const inpNameValue = isNewGroup || isTouched.name ? name : group.name;

    return (
      <Card>
        <Card.Header className="border-bottom">
          <h6 className="m-0">
            {isNewGroup ? 'Create New Group' : 'Edit Group Details'}
          </h6>
        </Card.Header>
        <Card.Body>
          <Col md="12">
            <Form className="d-flex flex-column">
              <FormGroup as={Col} md="12">
                <Form.Control
                  name="name"
                  className="col-md-12"
                  placeholder="Group Name"
                  value={inpNameValue}
                  onChange={this.onInputChange}
                />
              </FormGroup>
              <FormGroup className="d-flex justify-content-center">
                <Button type="button" onClick={this.submitForm}>
                  {isNewGroup ? 'Create Group' : 'Edit Group'}
                </Button>
              </FormGroup>
            </Form>
          </Col>
        </Card.Body>
      </Card>
    );
  }
}

CreateUser.propTypes = {
  isNewGroup: PropTypes.bool.isRequired,
  group: PropTypes.object.isRequired,
  triggerLoader: PropTypes.func.isRequired,
  addPageErrorMessage: PropTypes.func.isRequired,
  addNewGroupToList: PropTypes.func.isRequired,
  addPageSuccessMessage: PropTypes.func.isRequired,
  updateGroupDetailsInList: PropTypes.func.isRequired
};

const mapStateToProps = ({ groups }) => ({
  isNewGroup: !groups.activeGroupId,
  group: groups.list[groups.activeGroupId] || {}
});

const mapDispatchToProps = {
  addPageErrorMessage,
  triggerLoader,
  addNewGroupToList,
  addPageSuccessMessage,
  updateGroupDetailsInList
};

CreateUser.displayName = 'CreateUser';

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(CreateUser);
