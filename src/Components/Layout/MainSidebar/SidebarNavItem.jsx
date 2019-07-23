import React from 'react';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';

function SidebarNavItem({ item }) {
  return (
    <li className="nav-item">
      <Link className="nav-link" to={item.to}>
        <div className="d-inline-block item-icon-wrapper">
          <i className="material-icons">{item.icon}</i>
        </div>
        <span>{item.title}</span>
      </Link>
    </li>
  );
}

SidebarNavItem.propTypes = {
  item: PropTypes.object
};

SidebarNavItem.defaultProps = {
  item: {},
};

export default SidebarNavItem;
