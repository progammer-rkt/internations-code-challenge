import { applyMiddleware, createStore } from 'redux';
import thunkMiddleware from 'redux-thunk';
import { composeWithDevTools } from 'redux-devtools-extension';

import RootReducer from './Reducers/Root';

const middlewareEnhancer = applyMiddleware(thunkMiddleware);
const composedEnhancers = composeWithDevTools(middlewareEnhancer);
const preloadedState = {};
const store = createStore(RootReducer, preloadedState, composedEnhancers);

export default store;
