import './stylesheets/styles.scss';

import Events from 'Blocks/Events';
import SchoolTraining from 'Blocks/school-training';

import App from './App';

import guid from './common/guid';
import Menu from './common/Menu';

require('Blocks/movie');
require('Blocks/adult-training');
require('Blocks/home');

require.context('svg/', true);
require.context('icons/', true);

window.app = new App();

// Events
const events = new Events('.js-events');
events.setupEvents();

SchoolTraining('.js-school-trainings');

guid();

// Menu
const menu = new Menu();
menu.setupEvents();
