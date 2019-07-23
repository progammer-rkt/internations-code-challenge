import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import {
  updateShowStatusOfCreateGroupForm,
  updateActiveGroupId
} from '../../../../Redux/Actions';

class EditLink extends React.Component {
  constructor(props) {
    super(props);
    this.click = this.click.bind(this);
  }

  click(event) {
    event.preventDefault();
    event.stopPropagation();
    const {
      groupId,
      updateActiveGroupId,
      updateShowStatusOfCreateGroupForm
    } = this.props;
    updateShowStatusOfCreateGroupForm(true);
    updateActiveGroupId(`item-${groupId}`);
  }

  render() {
    return (
      <a href="#" onClick={this.click}>
        Edit
      </a>
    );
  }
}

EditLink.propTypes = {
  groupId: PropTypes.number,
  updateShowStatusOfCreateGroupForm: PropTypes.func.isRequired,
  updateActiveGroupId: PropTypes.func.isRequired
};

EditLink.defaultProps = {
  groupId: 0
};

const mapDispatchToProps = {
  updateShowStatusOfCreateGroupForm,
  updateActiveGroupId
};

EditLink.displayName = 'EditLink';

export default connect(
  null,
  mapDispatchToProps
)(EditLink);
