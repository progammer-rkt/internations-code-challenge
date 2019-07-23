import React from 'react';
import Form from 'react-bootstrap/Form';
import InputGroup from 'react-bootstrap/InputGroup';
import Button from 'react-bootstrap/Button';

export default () => (
  <Form
    className="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none"
    style={{ display: 'flex', minHeight: '45px' }}
  >
    <InputGroup seamless className="ml-3">
      <InputGroup.Prepend>
        <Button>
          <i className="material-icons">search</i>
        </Button>
        <InputGroup.Text
          className="navbar-search"
          placeholder="Search for something..."
          aria-label="Search"
        />
      </InputGroup.Prepend>
    </InputGroup>
  </Form>
);
