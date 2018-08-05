export default {
    downloadExl: function (titles, tableData, source, fileName, type) {  // 导出到excel
        let data = [{}];
        let i = 0;
        for (let value of titles) {
            data[i] = value.label;
            i = i + 1;
        }

        let param = {
            title: data,
            tableData: tableData,
            fileName: fileName,
            source: source,
            type: type
        }

        axios({
            method: 'post',
            url: '/api/exportExcel',
            responseType: 'arraybuffer',
            data: param
        }).then(response => {
            console.log(response);
            let blob = new Blob([response.data], {type: 'application/msexcel'})
            var href = URL.createObjectURL(blob)  // 创建对象超链接
            let outFile = document.createElement('a');
            outFile.download = fileName + '.' + type  // 下载名称
            outFile.href = href  // 绑定a标签
            outFile.click();  // 模拟点击实现下载
            setTimeout(function () {  // 延时释放
                URL.revokeObjectURL(blob) // 用URL.revokeObjectURL()来释放这个object URL
            }, 100)
            outFile.remove();

        })
            .catch(function (error) {
                console.log(error);
            });


    }
}