import './stylesheets/styles.scss';

import Events from 'Blocks/Events';
import SchoolTraining from 'Blocks/SchoolTraining';

import App from './App';

import guid from './common/guid';
import Menu from './common/Menu';

const bodyClasses = document.body.className.split(' ');

// Collège au cinéma 37
if (bodyClasses.includes('page-template-college-au-cinema-37')) {
    import('Blocks/movie' /* webpackChunkName: "adult-training", webpackPreload: true */);
}

// Formations pour les adultes
if (bodyClasses.includes('parent-pageid-181')) {
    import('Blocks/adult-training' /* webpackChunkName: "movie", webpackPreload: true */);
}

// Home
if (bodyClasses.includes('home')) {
	import('Blocks/home' /* webpackChunkName: "home", webpackPreload: true */);
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
