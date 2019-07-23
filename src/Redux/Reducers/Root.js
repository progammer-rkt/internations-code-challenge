import { combineReducers } from 'redux';

import usersReducer from './User';
import groupReducer from './Group';
import PageReducer from './Page';

export default combineReducers({
  groups: groupReducer,
  page: PageReducer,
  users: usersReducer
});
