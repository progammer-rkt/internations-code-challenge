import React from 'react';
import Col from 'react-bootstrap/Col';

import SidebarMainNavbar from './MainSidebar/SidebarMainNavbar';
import SidebarSearch from './MainSidebar/SidebarSearch';
import SidebarNavItems from './MainSidebar/SidebarNavItems';

function MainSidebar() {
  return (
    <Col tag="aside" className="main-sidebar px-0 col-12" lg={2} md={3}>
      <SidebarMainNavbar />
      <SidebarSearch />
      <SidebarNavItems />
    </Col>
  );
}

export default MainSidebar;
