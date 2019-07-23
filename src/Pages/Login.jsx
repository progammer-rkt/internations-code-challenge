import React from 'react';
import PropTypes from 'prop-types';
import { withRouter } from 'react-router-dom';
import { connect } from 'react-redux';

import '../css/home.css';
import userAvatar from '../images/login-user.png';
import { authenticateUser } from '../Async';
import {
  addPageErrorMessage,
  addPageSuccessMessage,
  updateUserToken,
  triggerLoader
} from '../Redux/Actions';
import { PageMessage } from '../Components/Common';

class Login extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      username: '',
      password: ''
    };

    this.formSubmit = this.formSubmit.bind(this);
    this.onInputChange = this.onInputChange.bind(this);
  }

  onInputChange(event) {
    const inpTarget = event.target.name;
    const inpValue = event.target.value;
    this.setState({ [inpTarget]: inpValue });
  }

  formSubmit(event) {
    event.preventDefault();
    const {
      history,
      addPageErrorMessage,
      addPageSuccessMessage,
      updateUserToken,
      triggerLoader
    } = this.props;
    const { username, password } = this.state;

    if (!username || !password) {
      addPageErrorMessage('All fields are required');
      return false;
    }

    triggerLoader(true);

    authenticateUser({ ...this.state })
      .then(response => {
        triggerLoader(false);
        if (response && response.token) {
          addPageSuccessMessage('Logged in successfully');
          updateUserToken(response.token);
          history.push('/dashboard');
        } else {
          addPageErrorMessage('Login failed. Please try again');
        }
      })
      .catch(error => {
        triggerLoader(false);
        if (
          error &&
          error.data &&
          error.data.error &&
          Array.isArray(error.data.error)
        ) {
          addPageErrorMessage(error.data.error.toString());
        } else {
          addPageErrorMessage('Login failed. Please try again');
        }
      });
  }

  render() {
    const { username, password } = this.state;
    return (
      <div className="wrapper fadeInDown">
        <div id="formContent">
          <div className="fadeIn first">
            <img src={userAvatar} id="icon" alt="User Icon" />
          </div>
          <form>
            <PageMessage />
            <input
              type="text"
              id="login"
              className="fadeIn second"
              name="username"
              placeholder="login"
              value={username}
              onChange={this.onInputChange}
            />
            <input
              type="text"
              id="password"
              className="fadeIn third"
              name="password"
              placeholder="password"
              value={password}
              onChange={this.onInputChange}
            />
            <input
              type="button"
              onClick={this.formSubmit}
              className="fadeIn fourth"
              value="Log In"
            />
          </form>
          <div id="formFooter" />
        </div>
      </div>
    );
  }
}

Login.propTypes = {
  history: PropTypes.array.isRequired,
  addPageErrorMessage: PropTypes.func.isRequired,
  addPageSuccessMessage: PropTypes.func.isRequired,
  updateUserToken: PropTypes.func.isRequired,
  triggerLoader: PropTypes.func.isRequired
};

const mapDispatchToProps = {
  addPageErrorMessage,
  addPageSuccessMessage,
  updateUserToken,
  triggerLoader
};

const RoutedLogin = withRouter(Login);

RoutedLogin.displayName = 'LoginPage';

export default connect(
  null,
  mapDispatchToProps
)(RoutedLogin);
