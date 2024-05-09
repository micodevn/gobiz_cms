class FileHelper {
    getFile(fileInput) {
        if (fileInput instanceof File) {
            return fileInput;
        }
        var files = fileInput.files;
        if (files.length === 0) {
            return null;
        }
        filePreview = files[0];
        return files[0];
    }

    getName(fileInput) {
        const file = this.getFile(fileInput)
        if (!file) {
            return null;
        }
        return file.name;
    }

    getType(fileInput) {
        if (typeof fileInput === 'string') {
            return fileType;
        }
        const file = this.getFile(fileInput)
        if (!file) {
            return null;
        }

        const type = file.type;
        const name = file.name;

        if (type.startsWith('image')) {
            return IMAGE;
        }

        if (type.startsWith('application/pdf')) {
            return PDF;
        }

        if (type.startsWith('video')) {
            return VIDEO;
        }

        if (type.startsWith('audio')) {
            return AUDIO;
        }

        if (type.startsWith('audio')) {
            return AUDIO;
        }

        if (type.startsWith('application/msword')) {
            return DOCUMENT;
        }

        if (type.startsWith('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) {
            return DOCUMENT;
        }

        if (name.endsWith('.edb')) {
            return CLASSIN;
        }

        return ASSET_BUNDLE;
    }

    getFileUrl(file) {
        if (typeof file === 'string') {
            return file;
        }

        return URL.createObjectURL(file);
    }

    getLinkName(link) {
        return /[^/]*$/.exec(link)[0];
    }

    getSize(file) {
        return file.files[0].size;
    }


    /**
     * Format bytes as human-readable text.
     *
     * @param bytes Number of bytes.
     * @param si True to use metric (SI) units, aka powers of 1000. False to use
     *           binary (IEC), aka powers of 1024.
     * @param dp Number of decimal places to display.
     *
     * @return Formatted string.
     */
    humanFileSize(bytes, si=true, dp=2) {
        const thresh = si ? 1024 : 1000;

        if (Math.abs(bytes) < thresh) {
            return bytes + ' B';
        }

        const units = si
            ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
            : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
        let u = -1;
        const r = 10**dp;

        do {
            bytes /= thresh;
            ++u;
        } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);


        return bytes.toFixed(dp) + ' ' + units[u];
    }

    mapExtensionToTypeName(extension) {
        extension = extension.toUpperCase();
        const attributeName = {
            "IMAGE": [
                'JPEG',
                'JPG',
                'PNG',
                'GIF',
                'TIFF',
                'PSD',
                'PDF',
                'EPS'
            ],
            "VIDEO": [
                'MP4',
                'MOV',
                'WMV',
                'AVI',
                'AVCHD',
                'FLV',
                'F4V',
                'SWF',
                'MKV',
                'WEBM'
            ],
            "AUDIO":[
                'MP3',
                'AAC',
                'FLAC',
                'ALAC',
                'WAV',
                'AIFF',
                'DSD'
            ]
        }

        let nameType = "ASSET_BUNDLE";
        for (let key in attributeName) {
            let check = attributeName[key].filter(ele => ele == extension);
            if (check.length) {
                nameType = key;
                break;
            }
        }
        return nameType;
    }

}

const fileHelper = new FileHelper();
