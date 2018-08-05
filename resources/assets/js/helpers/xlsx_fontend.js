import XLSX from 'xlsx';

export default {
    downloadExl: function (titles, tableData, downName, type) {  // 导出到excel
        let data = [{}];
        for (let value of titles) {
            data[0][value.prop] = value.label
        }
        data = data.concat(tableData);

        let keyMap = [] // 获取键
        for (let k in data[0]) {
            keyMap.push(k)
        }
        console.info('keyMap', keyMap, data)
        let tmpdata = [] // 用来保存转换好的json
        data.map((v, i) => keyMap.map((k, j) => Object.assign({}, {
            v: v[k],
            position: (j > 25 ? this.getCharCol(j) : String.fromCharCode(65 + j)) + (i + 1)
        }))).reduce((prev, next) => prev.concat(next)).forEach(function (v) {
            tmpdata[v.position] = {
                v: v.v
            }
        })
        let outputPos = Object.keys(tmpdata)  // 设置区域,比如表格从A1到D10
        let tmpWB = {
            SheetNames: ['mySheet'], // 保存的表标题
            Sheets: {
                'mySheet': Object.assign({},
                    tmpdata, // 内容
                    {
                        '!ref': outputPos[0] + ':' + outputPos[outputPos.length - 1] // 设置填充区域
                    })
            }
        }
        let tmpDown = new Blob([this.s2ab(XLSX.write(tmpWB,
            {bookType: (type === undefined ? 'xlsx' : type), bookSST: false, type: 'binary'} // 这里的数据是用来定义导出的格式类型
        ))], {
            type: ''
        })  // 创建二进制对象写入转换好的字节流
        var href = URL.createObjectURL(tmpDown)  // 创建对象超链接
        let outFile = document.createElement('a');
        outFile.download = downName + '.' + type  // 下载名称
        outFile.href = href  // 绑定a标签
        outFile.click();  // 模拟点击实现下载
        setTimeout(function () {  // 延时释放
            URL.revokeObjectURL(tmpDown) // 用URL.revokeObjectURL()来释放这个object URL
        }, 100)
        outFile.remove();
    },
    s2ab: function (s) { // 字符串转字符流
        var buf = new ArrayBuffer(s.length)
        var view = new Uint8Array(buf)
        for (var i = 0; i !== s.length; ++i) {
            view[i] = s.charCodeAt(i) & 0xFF
        }
        return buf
    },
}
