// uploadFunc.js

var fileModule = (function () {
    var vApi;
    var user_id;
    var vColFK;
    var cameraElement;
    var takePhotoButton;
    var isUploading = false;

    // Inisialisasi modul dengan parameter
    function init(apiUrl, colFk, userid) {
        vApi = apiUrl;
        vColFK = colFk;
        user_id = userid;
        cameraElement = document.getElementById("camera");
        takePhotoButton = document.getElementById("take-photo");
    }

    function activateCamera(idfk) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                cameraElement.srcObject = stream;
            })
            .catch(function (error) {
                console.error("Error accessing camera:", error);
            });

        takePhotoButton.addEventListener("click", function () {
            if (!isUploading) {
                isUploading = true;
                takePhotoButton.disabled = true;

                const canvas = document.createElement("canvas");
                const scaleFactor = 1.5;
                const targetWidth = cameraElement.videoWidth * scaleFactor;
                const targetHeight = cameraElement.videoHeight * scaleFactor;

                canvas.width = targetWidth;
                canvas.height = targetHeight;

                const context = canvas.getContext("2d");
                context.drawImage(
                    cameraElement,
                    (cameraElement.videoWidth - targetWidth) / 2,
                    (cameraElement.videoHeight - targetHeight) / 2,
                    targetWidth,
                    targetHeight,
                    0,
                    0,
                    canvas.width,
                    canvas.height
                );
                canvas.toBlob(function (blob) {
                    if (blob) {
                        // Ganti dengan fungsi yang sesuai
                        uploadFile(idfk, blob, 'capture.jpg');
                    }
                    isUploading = false;
                    takePhotoButton.disabled = false;
                }, "image/jpeg", 1);
            }
        });
    }

    function stopCamera() {
        const stream = cameraElement.srcObject;
        if (stream) {
            const tracks = stream.getTracks();
            tracks.forEach(function (track) {
                track.stop();
            });
            cameraElement.srcObject = null;
        }
    }

    function upload(idFk) {
        var fileInput = $('<input type="file" id="lampiran" name="lampiran" accept=".jpg, .jpeg, .png, .pdf" style="display: none;">');
        $("body").append(fileInput);
        fileInput.click();
        // console.log('upload '+idFk);

        fileInput.change(function () {
            var selectedFile = this.files[0];
            if (selectedFile) {
                uploadFile(idFk, selectedFile);
            }
        });
    }

    function uploadFile(idFk, file, fileName) {
        const formData = new FormData();
        formData.append("user_id", user_id);
        formData.append("file", file, fileName);
        // console.log('uploadFile '+idFk);
        $.ajax({
            url: 'api/upload',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    linkFile(response.data.id, idFk).then(function () {
                        loadData();
                    }).catch(function (error) {
                        console.error(error);
                    });

                } else {
                    appShowNotification(false, ["Failed to upload attachment."]);
                }
            },
            error: function (xhr, status, error) {
                appShowNotification(false, ["Something went wrong. Please try again later."]);
            }
        });
    }

    function linkFile(upload_id, idFk) {
        var formData = new FormData();
        formData.append('upload_id', upload_id);
        formData.append(vColFK, idFk);
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: vApi,
                data: formData,
                processData: false,
                contentType: false,            
                success: function (response) {
                    if (response.success) {
                        appShowNotification(response.success, [response.message]);
                        resolve();
                    } else {
                        appShowNotification(false, ["Failed to link attachment."]);
                        reject("Failed to link attachment.");
                    }
                },
                error: function (xhr, status, error) {
                    appShowNotification(false, ["Something went wrong. Please try again later."]);
                    reject("Something went wrong. Please try again later.");
                },
            });
        });
    }

    function deleteLink(id, upload_id) {
        if (confirm("apakah anda yakin?")) {
            $.ajax({
                type: "DELETE",
                url: vApi + "/" + id,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        if (confirm("Tautan berhasil dihapus, apakah anda juga ingin menghapus secara permanen file tersebut?")) {
                            deleteFile(upload_id).then(function () {
                                loadData();
                            }).catch(function (error) {
                                console.error(error);
                            });
                        }
                    } else {
                        appShowNotification(false, ["Failed to upload attachment."]);
                    }
                },
                error: function (xhr, status, error) {
                    appShowNotification(false, ["Something went wrong. Please try again later."]);
                },
            });
        }
    }

    function deleteFile(upload_id) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: "DELETE",
                url: "api/upload/" + upload_id,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        appShowNotification(response.success, [response.message]);
                        resolve();
                    } else {
                        appShowNotification(false, ["Failed to delete attachment."]);
                        reject("Failed to delete attachment.");
                    }
                },
                error: function (xhr, status, error) {
                    appShowNotification(false, ["Something went wrong. Please try again later."]);
                    reject("Something went wrong. Please try again later.");
                },
            });
        });
    }

    return {
        init: init,
        activateCamera: activateCamera,
        stopCamera: stopCamera,
        upload: upload,
        uploadFile: uploadFile,
        linkFile: linkFile,
        deleteLink: deleteLink,
        deleteFile: deleteFile,
    };

})();
