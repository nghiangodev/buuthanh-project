<template>
    <div id="app">
        <file-pond name="file" ref="pond" :label-idle="browseFileText" v-bind:allow-multiple="false" v-bind:files="myFiles" v-on:init="handleFilePondInit" v-on:updatefiles="handleFilePondUpdate" v-bind:accepted-file-types="fileTypes"/>
    </div>
</template>
<style>
    .filepond--drop-label {
        background: hsl(210, 38%, 97%);
    }

    .filepond--drop-label:hover {
        cursor: pointer;
    }
</style>
<script>
	// Import Vue FilePond
	import vueFilePond from 'vue-filepond'

	// Import FilePond styles
	import 'filepond/dist/filepond.min.css'
	// Import FilePond plugins

	// Import image preview plugin styles
	import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'

	// Import image preview and file type validation plugins
	import FilePondPluginImagePreview from 'filepond-plugin-image-preview'

	// Create component
	const FilePond = vueFilePond(
		FilePondPluginImagePreview,
	)

	// noinspection JSUnusedGlobalSymbols
	export default {
		props: ['file', 'browseFileText', 'fileType'],
		name: 'app',
		data: function() {
			return {
				myFiles: this.file ? [this.file] : [],
				fileTypes: this.fileType ? this.fileType : '',
			}
		},
		methods: {
			handleFilePondInit: function() {
				console.log('FilePond has initialized')

				// FilePond instance methods are available on `this.$refs.pond`
			},
			handleFilePondUpdate() {

			},
		},
		components: {
			FilePond,
		},
	}
</script>
