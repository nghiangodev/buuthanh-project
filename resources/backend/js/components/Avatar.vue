<template>
    <div id="app">

        <file-pond
                name="avatar"
                ref="pond"
                :label-idle="browseFileText"

                accepted-file-types="image/jpeg, image/png"
                v-bind:allow-multiple="false"
                v-bind:files="myFiles"
                v-on:init="handleFilePondInit" v-on:updatefiles="handleFilePondUpdate"/>

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
	import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
	import FilePondPluginImagePreview from 'filepond-plugin-image-preview'

	// Create component
	const FilePond = vueFilePond(
		FilePondPluginFileValidateType,
		FilePondPluginImagePreview,
	)

	// noinspection JSUnusedGlobalSymbols
	export default {
		props: ['file', 'browseFileText'],
		name: 'app',
		data: function() {
			return {
				myFiles: this.file ? [this.file] : [],
			};
		},
		methods: {
			handleFilePondInit: function() {
				console.log('FilePond has initialized');

				// FilePond instance methods are available on `this.$refs.pond`
			},
			handleFilePondUpdate() {

            }
		},
		components: {
			FilePond
		}
	}
</script>
