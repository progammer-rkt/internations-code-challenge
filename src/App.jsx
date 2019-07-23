import React from 'react';
import { BrowserRouter as Router, Route } from 'react-router-dom';
import { Provider } from 'react-redux';

import { LoginPage, DashboardPage, UsersPage, GroupsPage } from './Pages';
import store from './Redux/Store';

function App() {
  return (
    <Provider store={store}>
      <Router>
        <Route path="/" exact component={LoginPage} />
        <Route path="/dashboard" component={DashboardPage} />
        <Route path="/users" component={UsersPage} />
        <Route path="/groups" component={GroupsPage} />
      </Router>
    </Provider>
  );
}

export default App;
