import './stylesheets/styles.scss';

import App from './App';

import Events from './blocks/events';
import SchoolTraining from './blocks/school-training';

import guid from './common/guid';
import Menu from './common/Menu';

import './blocks/movie';
import './blocks/adult-training';
import './blocks/home';

require.context('svg/', true);
require.context('icons/', true);

window.app = new App();

Events('.js-events');
SchoolTraining('.js-school-trainings');

guid();

// Menu
const menu = new Menu();
menu.setupEvents();
