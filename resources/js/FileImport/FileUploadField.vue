<template>
    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <a href="files/employee_infomation.CSV">例えはこちら</a>
        <!-- ドラッグ＆ドロップ領域 -->
        <div class="col-span-full">
            <label for="cover-photo" class="block text-sm/6 font-medium font-semibold text-gray-900">CSV添付</label>
            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
            @drop.prevent="onDrop($event)"
            @dragenter.prevent
            @dragover.prevent
            >
                <div class="text-center">
                    <div class="mt-4 flex text-sm/6 text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer rounded-md gb-white font-semibold text-indigo-600 focus-within:ring-2-offset-2 focus-within:outline-hidden hover:text-indigo-500">
                            <span>クリックして添付</span>
                            <input type="file" id="file-upload" name="file-upload" class="sr-only" @change="fileImport($event.target.files)" accept=".csv">
                        </label>
                        <p class="pl-1">ドラッグ＆ドロップで添付</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ファイルリスト -->
        <div class="col-span-full">
            <dt class="text-sm/6 font-medium font-semibold text-gray-900">ファイルリスト</dt>
            <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                <li class="flex items-center justify-between py-4 pr-5 pl-4 text-sm/6"
                v-for="(item, index) in fileList" :key="index">
                    <div class="flex w-0 flex-1 items-center">
                        <div class="flex min-w-0 flex-1 gap-2">
                            <span class="truncate font-medium">{{ item.name }}</span>
                            <button type="button" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-400 shadow-sm ring-1 ring-gray-300 ring-inset hover:bg-gray-50" 
                            @click="removeFile(item, index)">取り消し</button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div v-html="fileContent"></div>
</template>

<script>
import axios from 'axios'
    export default {
        data(){
            return {
                fileList: [],
                fileContent: ''
            }
        },
        methods:{
            onDrop(event) {
                const files = event.dataTransfer.files;
                this.fileImport(files);
            },
            fileImport(files) {
                if( !files.length || files.length != 1 ) {
                    alert('ファイルは一つずつアップロードしてください。');
                    return false;
                }
                if(this.checkExt(files) !== true) return;
                this.fileList.push(...files);
                this.submitForm();
            },
            submitForm() {
                const formData = new FormData();
                this.fileList.forEach((file) => {
                    formData.append('files[]', file);
                });
                axios.post('/fileImport', formData, {
                    header: {
                        'Context-Type': 'multipart/form-data'
                    }
                })
                    .then(res => {
                        if( res.data.success == true ) {
                            this.fileContent = res.data.html;
                        } else {
                            alert(res.data.message);
                        }
                    })
                    .catch(err => {
                        alert('ファイルアップロードに失敗しました。');
                    });
            },
            checkExt(file) {
                for(var i=0; i<file.length; i++) {
                    if( file[i].type.toLowerCase() != 'text/csv' ) {
                        alert('csvファイルでアップロードしてください');
                        return false;
                    }
                    const fileSplit = file[i].name.split('.');
                    if(fileSplit[fileSplit.length-1].toLowerCase() != 'csv') {
                        alert('csvファイルでアップロードしてください');
                        return false;
                    }

                }
                return true;
            },
            removeFile( file, idx ) {
                if(confirm('['+file.name+']を削除しますか？')) {
                    this.fileList.splice(idx, 1);
                    this.fileContent = '';
                }
            }
        },
    }
</script>