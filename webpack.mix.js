require('dotenv').config()
const fs = require('fs')
const theme = process.env.APP_THEME !== undefined ? process.env.APP_THEME : 'light'
const withCustom = process.argv[5]

const mix = require('laravel-mix')

mix.options({
	processCssUrls: false,
	terser: {
		extractComments: false,
	}
})

mix.webpackConfig(webpack => {
	return {
		node: {
			fs: 'empty',
		},
		output: {
			pathinfo: false,
		},
		plugins: [
			new webpack.HashedModuleIdsPlugin({
				hashFunction: 'sha256',
				hashDigest: 'hex',
				hashDigestLength: 20
			})
		],
	}
})

let getFiles = function(dir) {
	if (fs.existsSync(dir)) {
		return fs.readdirSync(dir).filter(file => {
			const stats = fs.statSync(`${dir}/${file}`)
			return stats.isFile()
		})
	}

	return []
}

let getFolders = function(dir) {
	if (fs.existsSync(dir)) {
		return fs.readdirSync(dir).filter(file => {
			const stats = fs.statSync(`${dir}/${file}`)
			return !stats.isFile()
		})
	}

	return []
};

(function backendConfig() {
	const resourcePath = 'resources/backend/'
	const distPath = 'public/backend/'

	if (['--all', '--theme'].includes(withCustom)) {
		// mix.combine([
		// 	`${resourcePath}/themes/vendors/plugins.bundle.js`,
		// 	`${resourcePath}/plugins/datatables/datatables.bundle.js`,
		// ], `${distPath}/themes/vendors/plugins.bundle.js`)
		//
		// mix.combine([
		// 	`${resourcePath}/themes/vendors/plugins.bundle.css`,
		// 	`${resourcePath}/plugins/datatables/datatables.bundle.css`,
		// ], `${distPath}/themes/vendors/plugins.bundle.css`)
		//
		// mix.js([
		// 	`${resourcePath}/themes/${theme}/assets/js/global/components/base/util.js`,
		// 	`${resourcePath}/themes/${theme}/assets/js/global/components/base/app.js`,
		//
		// 	`${resourcePath}/themes/assets/js/global/components/base/avatar.js`,
		// 	`${resourcePath}/themes/assets/js/global/components/base/dialog.js`,
		// 	`${resourcePath}/themes/assets/js/global/components/base/header.js`,
		// 	`${resourcePath}/themes/assets/js/global/components/base/menu.js`,
		// 	`${resourcePath}/themes/assets/js/global/components/base/offcanvas.js`,
		// 	`${resourcePath}/themes/assets/js/global/components/base/portlet.js`,
		// 	`${resourcePath}/themes/assets/js/global/components/base/scrolltop.js`,
		// 	`${resourcePath}/themes/assets/js/global/components/base/toggle.js`,
		// 	`${resourcePath}/themes/assets/js/global/components/base/wizard.js`,
		//
		// 	`${resourcePath}/themes/${theme}/assets/js/global/layout/layout.js`,
		//
		// 	`${resourcePath}/themes/assets/js/layout/offcanvas-panel.js`,
		// 	`${resourcePath}/themes/assets/js/layout/quick-panel.js`,
		// 	`${resourcePath}/themes/assets/js/layout/quick-search.js`,
		// ], `${distPath}/themes/${theme}/js/scripts.bundle.js`)

		mix.sass(`${resourcePath}/themes/${theme}/assets/sass/style.scss`, `${distPath}/themes/${theme}/css/style.bundle.css`);
	}

	if (['--all', '--core-js', '--core'].includes(withCustom)) {
		mix.js(`${resourcePath}js/app/app.js`, `${distPath}/js`)
		mix.js(`${resourcePath}js/app/bootstrap.js`, `${distPath}/js`)
		mix.js(`${resourcePath}js/app/bootstrap_login.js`, `${distPath}/js`)
	}

	if (['--custom'].includes(withCustom)) {
		let backendMiscJsPath = `${resourcePath}js/app/misc`
		getFiles(backendMiscJsPath).forEach(function(filepath) {
			mix.js(`${backendMiscJsPath}/${filepath}`, `${distPath}/js/misc`)
		})
	}

	if (['--all', '--core-sass', '--core'].includes(withCustom)) {
		mix.sass(`${resourcePath}/sass/themes/${theme}/app.scss`, `${distPath}/themes/${theme}/css`)
	}

	if (['--all', '--auth'].includes(withCustom)) {
		mix.sass(`${resourcePath}/sass/auth/login.scss`, `${distPath}/css`)
		mix.sass(`${resourcePath}/sass/auth/register.scss`, `${distPath}/css`)

		mix.js(`${resourcePath}/js/auth/register.js`, `${distPath}/js`)
		mix.js(`${resourcePath}/js/auth/login.js`, `${distPath}/js`)
	}

	if (! ['--core-sass', '--core-js', '--core', '--auth', '--custom', '--theme'].includes(withCustom)) {
		let routesObj = JSON.parse(fs.readFileSync('./routes/config/routes.json', 'utf8'))
		for (let namespace of Object.keys(routesObj)) {
			let folderNames = routesObj[namespace]
			for (let folderName of folderNames) {
				const jsDirPath = `${resourcePath}/js/modules/${namespace}/${folderName}`
				getFiles(`${jsDirPath}`).forEach(function(filepath) {
					mix.js(`${jsDirPath}/` + filepath, `${distPath}/js/${namespace}/${folderName}`)
				})

				getFolders(`${jsDirPath}`).forEach(function(folderpath) {
					const folderDirPath = `${resourcePath}/js/modules/${namespace}/${folderName}/${folderpath}`
					getFiles(`${folderDirPath}`).forEach(function(filepath) {
						mix.js(`${folderDirPath}/` + filepath, `public/js/${namespace}/${folderName}/${folderpath}`)
					})
				})
			}
		}
	}
})()

function frontendConfig() {
	const resourcePath = 'resources/frontend'
	const distPath = 'public/frontend/'

	let frontendSassPath = `${resourcePath}sass/frontend`
	getFiles(frontendSassPath).forEach(function(filepath) {
		mix.sass(`${frontendSassPath}/${filepath}`,  `${distPath}/css`)
	})
	let frontendJsPath = `${resourcePath}js/modules/frontend`
	getFiles(frontendJsPath).forEach(function(filepath) {
		mix.js(`${frontendJsPath}/${filepath}`,  `${distPath}/js`)
	})
}

mix.browserSync({
	proxy: 'http://127.0.0.1:8000',
	browser: [],
	reloadDelay: 1000,
	injectChanges: false,
	ghostMode: true,
	notify: false,
})

Mix.manifest.refresh = _ => void 0