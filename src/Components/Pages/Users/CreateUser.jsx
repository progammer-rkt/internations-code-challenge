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
  addNewUserToList,
  addPageSuccessMessage,
  updateUserDetailsList
} from '../../../Redux/Actions';
import { updateUserDetailsRequest, createUserRequest } from '../../../Async';

const initialState = {
  fullname: '',
  country: '',
  isTouched: {
    fullname: false,
    country: false
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
   * add new user button, the form is not clearing. This is due to the
   * component's isTouched state is not reset. We are enforcing whenever
   * a add new user button is clicked.
   */
  componentDidUpdate(oldProps) {
    const { isNewUser: oldIsNewUser } = oldProps;
    const { isNewUser: newIsNewUser } = this.props;

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
    const { fullname, country, isTouched } = this.state;
    const {
      isNewUser,
      user,
      addPageErrorMessage,
      triggerLoader,
      addPageSuccessMessage,
      addNewUserToList,
      updateUserDetailsList
    } = this.props;

    // make sure form is touched
    if (!Object.keys(isTouched).find(field => isTouched[field] === true)) {
      addPageErrorMessage('There is no change in the form; Sorry');
      return;
    }

    // make sure there is fullname exist
    if (!fullname) {
      addPageErrorMessage('Name field cannot be empty; Sorry');
      return;
    }

    triggerLoader(true);

    if (isNewUser) {
      createUserRequest({ fullname, country })
        .then(newUser => {
          addNewUserToList({ ...newUser });

          triggerLoader(false);
          addPageSuccessMessage('User created successfully');
        })
        .catch(this.requestCatch);
    } else {
      const data = {
        id: user.id,
        fullname: fullname === '' ? user.fullname : fullname,
        country: country === '' ? user.country : country
      };
      updateUserDetailsRequest(data)
        .then(updatedUser => {
          updateUserDetailsList({ ...updatedUser });
          triggerLoader(false);
          addPageSuccessMessage('User details edited successfully');
        })
        .catch(this.requestCatch);
    }
  }

  render() {
    const { fullname, country, isTouched } = this.state;
    const { isNewUser, user } = this.props;
    const inpFullNameValue =
      isNewUser || isTouched.fullname ? fullname : user.fullname;
    const inpCountryValue =
      isNewUser || isTouched.country ? country : user.country;

    return (
      <Card>
        <Card.Header className="border-bottom">
          <h6 className="m-0">
            {isNewUser ? 'Create New User' : 'Edit User Details'}
          </h6>
        </Card.Header>
        <Card.Body>
          <Col md="12">
            <Form className="d-flex flex-column">
              <FormGroup as={Col} md="12">
                <Form.Control
                  name="fullname"
                  className="col-md-12"
                  placeholder="Full Name"
                  value={inpFullNameValue}
                  onChange={this.onInputChange}
                />
              </FormGroup>
              <FormGroup as={Col} md="12">
                <Form.Control
                  name="country"
                  className="col-md-12"
                  placeholder="Country"
                  value={inpCountryValue}
                  onChange={this.onInputChange}
                />
              </FormGroup>
              <FormGroup className="d-flex justify-content-center">
                <Button type="button" onClick={this.submitForm}>
                  {isNewUser ? 'Create User' : 'Edit User'}
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
  isNewUser: PropTypes.bool.isRequired,
  user: PropTypes.object.isRequired,
  triggerLoader: PropTypes.func.isRequired,
  addPageErrorMessage: PropTypes.func.isRequired,
  addNewUserToList: PropTypes.func.isRequired,
  addPageSuccessMessage: PropTypes.func.isRequired,
  updateUserDetailsList: PropTypes.func.isRequired
};

const mapStateToProps = ({ page, users }) => ({
  isNewUser: !page.users.activeUserId,
  user: users.list[page.users.activeUserId] || {}
});

const mapDispatchToProps = {
  addPageErrorMessage,
  triggerLoader,
  addNewUserToList,
  addPageSuccessMessage,
  updateUserDetailsList
};

CreateUser.displayName = 'CreateUser';

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(CreateUser);
