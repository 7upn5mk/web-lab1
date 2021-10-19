$(document).ready(function() {
    const errors = $("#errors")[0]
    const result_table = $("#result-table")[0]

    $("#x-values :button").click(function () {
        $("#x-values :button").removeClass("active") /*input[type='button']*/
        $(this).addClass("active")
    });
    $("#submit")[0].addEventListener("click", async function (event) {
        event.preventDefault()
        let coord = dataValidate()
        if (!coord) {
            return false;
        }
        const result = await connect(coord)
        if (result.hasOwnProperty("error")) {printError(result["error"])}
        else {
            let row = result_table.insertRow(-1)
            let properties = Object.keys(result)
            for (let property of properties) {
                let cell = row.insertCell(-1)
                let text = document.createTextNode(result[property])
                cell.appendChild(text)
            }
        }
    })
    $("#reset")[0].addEventListener("click",function (event){
        event.preventDefault()
        $("#x-values :button").removeClass("active")
        $("#y-values")[0].value = ""
        $("#r-values")[0].value = 1
        while(result_table.rows.length > 1){
            result_table.deleteRow(-1);
        }
    })

    function dataValidate() {
        const x_element = $("#x-values :button.active")[0]
        const y_value = $("#y-values")[0].value.replace(",",".")
        const r_value = $("#r-values")[0].value
        while (errors.firstChild) {errors.removeChild(errors.firstChild)}
        let errorCount = 0
        if (x_element===undefined) {printError("X can't be empty"); errorCount++}
        if (y_value==="") {printError("Y can't be empty"); errorCount++}
        else if (y_value>5 || y_value<-3 || isNaN(Number(y_value))) {printError("Y must be a number from -3 to 5"); errorCount++}
        if (errorCount>0) {return false}
        return {x: x_element.value, y: y_value, r: r_value}
    }

    async function connect(coord) {
        let form = new FormData()
        for (let key in coord) {
            form.append(key, coord[key])
        }
        const response = await fetch("main/main.php",{
            method: "POST",
            body: form
        })
        if (response.ok) {
            let result = await response.json()
            return result
        } else return JSON.parse('{"error":"'+response.status+': '+response.statusText+'"}')
    }

    function printError(s) {
        let node = document.createElement("LI");                 // Create a <li> node
        node.className = "error";
        let textnode = document.createTextNode(s);         // Create a text node
        node.appendChild(textnode);                              // Append the text to <li>
        errors.appendChild(node);     // Append <li> to <ul>
    }
})







