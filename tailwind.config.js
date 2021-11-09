const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
	purge: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./vendor/laravel/jetstream/**/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
		'./resources/js/**/*.vue'
	],

	theme: {
		extend: {
			colors: {
				transparent: 'transparent',
				current: 'currentColor',
				black: colors.black,
				white: colors.white,
				gray: colors.gray,
				red: colors.red,
				yellow: {
					400: '#FF7864'
				},
				green: colors.green,
				blue: {
					400: '#505FF5',
					500: '#224957',
					700: '#040038'
				},
				indigo: colors.indigo,
				purple: colors.violet,
				pink: colors.pink
			},
			extend: {
				fontFamily: {
					sans: [ 'Gellix', 'Nunito', ...defaultTheme.fontFamily.sans ],
					serif: [ 'ui-serif', 'Georgia', 'Cambria', '"Times New Roman"', 'Times', 'serif' ]
				}
			}
		}
	},

	plugins: [ require('@tailwindcss/forms'), require('@tailwindcss/typography') ]
};
