import React from 'react';

import SidebarNavItem from './SidebarNavItem';

class SidebarNavItems extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      navItems: [
        {
          id: 111111,
          title: 'Users',
          to: '/users',
          icon: 'face'
        },
        {
          id: 222222,
          title: 'Groups',
          to: '/groups',
          icon: 'group'
        }
      ]
    };
  }

  render() {
    const { navItems: items } = this.state;
    return (
      <div className="nav-wrapper">
        <ul className="nav--no-borders flex-column nav pl-0">
          {items.map(item => (
            <SidebarNavItem key={item.id} item={item} />
          ))}
        </ul>
      </div>
    );
  }
}

export default SidebarNavItems;
