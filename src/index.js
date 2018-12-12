import 'src/stylesheets/styles.scss';

import App from 'src/App';

import Events from 'Blocks/events';
import SchoolTraining from 'Blocks/school-training';

import guid from 'Common/guid';
import Menu from 'Common/Menu';

import 'Blocks/movie';
import 'Blocks/adult-training';
import 'Blocks/home';

require.context('svg/', true);
require.context('icons/', true);

window.app = new App();

Events('.js-events');
SchoolTraining('.js-school-trainings');

guid();

// Menu
const menu = new Menu();
menu.setupEvents();
