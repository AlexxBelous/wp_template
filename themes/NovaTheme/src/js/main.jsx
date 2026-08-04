import '@/scss/main.scss';
import '@fortawesome/fontawesome-free/css/all.min.css';
import '@/js/global.js';
import React from 'react';
import ReactDOM from 'react-dom/client';
import App from '@/components/App';

console.log( 'Main JS is loaded from Vite!' );

// Если на странице есть элемент с ID 'root', монтируем React-приложение
// const rootElement = document.getElementById( 'root' );

// if ( rootElement ) {
// 	ReactDOM.createRoot( rootElement ).render(
// 		<React.StrictMode>
// 			<App />
// 		</React.StrictMode>
// 	);
// }