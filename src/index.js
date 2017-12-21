import './assets/stylesheets/styles.scss';
import App from './app/modules/app';
import Events from './app/modules/events';
import SchoolTraining from './app/modules/school-training';
import guid from './app/modules/guid';
import Menu from './app/modules/Menu';
import './app/modules/movie';
import './app/modules/adult-training';
import './app/modules/home';

window.app = new App();

Events('.js-events');
SchoolTraining('.js-school-trainings');
guid();

// Menu
const MainMenu = new Menu();
MainMenu.setupEvents();

console.log('Yo!');
