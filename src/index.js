import './stylesheets/styles.scss';

import Events from 'blocks/Events';
import SchoolTraining from 'blocks/SchoolTraining';

import App from './App';

import guid from './common/guid';
import Menu from './common/Menu';

const bodyClasses = document.body.className.split(' ');

// Collège au cinéma 37
if (bodyClasses.includes('page-template-college-au-cinema-37')) {
	import('blocks/movie' /* webpackChunkName: "movie", webpackPreload: true */); // eslint-disable-line no-unused-expressions
}

// Formations pour les adultes
if (bodyClasses.includes('parent-pageid-181')) {
	import('blocks/adult-training' /* webpackChunkName: "adult-training", webpackPreload: true */); // eslint-disable-line no-unused-expressions
}

// Home
if (bodyClasses.includes('home')) {
	import('blocks/home' /* webpackChunkName: "home", webpackPreload: true */); // eslint-disable-line no-unused-expressions
}

require.context('svg/', true);
require.context('icons/', true);

window.app = new App();

// Events
const events = new Events('.js-events');
events.init();

// School training
const schoolTraining = new SchoolTraining('.js-school-trainings');
schoolTraining.init();

guid();

// Menu
const menu = new Menu();
menu.setupEvents();
