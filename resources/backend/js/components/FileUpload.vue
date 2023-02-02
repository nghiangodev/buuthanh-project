<template>
    <div class="dropzone dropzone-multi" id="fileupload">
        <div class="dropzone-panel">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="dropzone-select btn btn-brand" v-html=chooseFileText></button>
                <button type="button" class="dropzone-upload btn btn-success" v-html=uploadFileText></button>
                <button type="button" class="dropzone-remove-all btn btn-danger" v-html=deleteFileText></button>
            </div>
        </div>
        <div class="dropzone-items">
            <div class="dropzone-item" style="display:none">
                <div class="dropzone-file">
                    <div class="dropzone-filename" title=""><span data-dz-name></span> <strong>(<span data-dz-size></span>)</strong></div>
                    <div class="dropzone-error" data-dz-errormessage></div>
                </div>
                <div class="dropzone-progress">
                    <div class="progress">
                        <div class="progress-bar kt-bg-brand" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress></div>
                    </div>
                </div>
                <div class="dropzone-toolbar">
                    <span class="dropzone-start"><i class="flaticon2-arrow"></i></span>
                    <span class="dropzone-cancel" data-dz-remove style="display: none;"><i class="flaticon2-cross"></i></span>
                    <span class="dropzone-delete" data-dz-remove><i class="flaticon2-cross"></i></span>
                </div>
            </div>
        </div>
<!--        <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>-->
    </div>
</template>
<style>
    .input-group i {
        color: inherit;
    }
</style>
<script>
	// noinspection JSUnusedGlobalSymbols
	export default {
		props: ['url'],

		data() {
			return {
				uploadFileText: `<i class="far fa-upload"> ${__('Upload all')}`,
				chooseFileText: `<i class="far fa-folder-open"> ${__('Choose file')}`,
				deleteFileText: `<i class="far fa-trash"> ${__('Delete')}`,
				confirmFileText: `<i class="far fa-check"> ${__('Confirm')}`,
			}
		},

        mounted() {
			// set the dropzone container id
			const id = '#fileupload'
			// set the preview element template
			const previewNode = $(id + ' .dropzone-item')
			previewNode.id = ''
			const previewTemplate = previewNode.parent('.dropzone-items').html()
			previewNode.remove()
			const myDropzone4 = new Dropzone(id, { // Make the whole body a dropzone
				url: this.url, // Set the url for your upload script location
				parallelUploads: 20,
				previewTemplate: previewTemplate,
				maxFilesize: 1, // Max filesize in MB
				autoQueue: false, // Make sure the files aren't queued until manually added
				previewsContainer: id + ' .dropzone-items', // Define the container to display the previews
				clickable: id + ' .dropzone-select', // Define the element that should be used as click trigger to select files.
			})
			myDropzone4.on('addedfile', function(file) {
				// Hookup the start button
				file.previewElement.querySelector(id + ' .dropzone-start').onclick = function() {
					myDropzone4.enqueueFile(file)
				}
				$(document).find(id + ' .dropzone-item').css('display', '')
				$(id + ' .dropzone-upload, ' + id + ' .dropzone-remove-all').css('display', 'inline-block')
			})
			// Update the total progress bar
			myDropzone4.on('totaluploadprogress', function(progress) {
				$(this).find(id + ' .progress-bar').css('width', progress + '%')
			})
			myDropzone4.on('sending', function(file) {
				// Show the total progress bar when upload starts
				document.querySelector(id + ' .progress-bar').style.opacity = '1'
				// And disable the start button
				file.previewElement.querySelector(id + ' .dropzone-start').setAttribute('disabled', 'disabled')
			})
			// Hide the total progress bar when nothing's uploading anymore
			myDropzone4.on('complete', function(progress) {
				const thisProgressBar = id + ' .dz-complete'
				setTimeout(function() {
					$(thisProgressBar + ' .progress-bar, ' + thisProgressBar + ' .progress, ' + thisProgressBar + ' .dropzone-start').css('opacity', '0')
				}, 300)
			})
			// Setup the buttons for all transfers
			document.querySelector(id + ' .dropzone-upload').onclick = function() {
				myDropzone4.enqueueFiles(myDropzone4.getFilesWithStatus(Dropzone.ADDED))
			}
			// Setup the button for remove all files
			document.querySelector(id + ' .dropzone-remove-all').onclick = function() {
				$(id + ' .dropzone-upload, ' + id + ' .dropzone-remove-all').css('display', 'none')
				myDropzone4.removeAllFiles(true)
			}
			// On all files completed upload
			myDropzone4.on('queuecomplete', function(progress) {
				$(id + ' .dropzone-upload').css('display', 'none')
			})
			// On all files removed
			myDropzone4.on('removedfile', function(file) {
				if (myDropzone4.files.length < 1) {
					$(id + ' .dropzone-upload, ' + id + ' .dropzone-remove-all').css('display', 'none')
				}
			})
        }
	}
</script>
