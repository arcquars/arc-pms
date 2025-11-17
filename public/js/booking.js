function calculateCostBySectionId(sectionId){
    let discountType = parseInt($("#"+ sectionId +" input[name='cost[discount_type]']:radio:checked").val());
    let discount = 0;
    if(discountType == 1){
        discount = $("#"+ sectionId +" select[name='cost[discount]']").val()? parseFloat($("#"+ sectionId +" select[name='cost[discount]']").val()) : 0;
    } else {
        discount = $("#"+ sectionId +" input[name='cost[discount]']").val()? parseFloat($("#"+ sectionId +" input[name='cost[discount]']").val()) : 0;
    }
    let cCostExtraCharge = $("#"+ sectionId +" input[name='cost[extra_charge]']").val()? parseFloat($("#"+ sectionId +" input[name='cost[extra_charge]']").val()) : 0;
    let cCostForward = $("#"+ sectionId +" input[name='cost[forward]']").val()? parseFloat($("#"+ sectionId +" input[name='cost[forward]']").val()) : 0;
    let costTotal = $("#"+ sectionId +" input[name='cost[total]']").val()? parseFloat($("#"+ sectionId +" input[name='cost[total]']").val()) : 0;
    let total = 0;
    if(discountType === 1){
        if(discount === 0){
            total = costTotal + cCostExtraCharge - cCostForward;
        } else {
            total = (costTotal - (costTotal * discount / 100)) + cCostExtraCharge - cCostForward;
        }
    } else {
        total = costTotal + cCostExtraCharge - cCostForward - discount;
    }
    $("#"+ sectionId +" input[name='cost[total_pay]']").val(total.toFixed(2));
}

function showTypeDiscountBySectionId(seccionId, typeDiscount){
    let itemTemplatePercent = '<select name="cost[discount]" id="c-cost-discount" class="form-control" onchange="calculateCost();">';
    itemTemplatePercent += '<option value="">Seleccione...</option>';
    listDiscount.forEach(discount => {
        itemTemplatePercent += '<option value="'+discount+'">'+discount+'</option>';
    });
    itemTemplatePercent += '</select>';
    itemTemplatePercent += '<div class="input-group-prepend">';
    itemTemplatePercent += '<div class="input-group-text">%</div>';
    itemTemplatePercent += '</div>';
    itemTemplatePercent += '<div class="invalid-feedback"></div>';

    let itemTemplateMoney = '<div class="input-group-prepend">';
    itemTemplateMoney += '<div class="input-group-text">Bs</div>';
    itemTemplateMoney += '</div>';
    itemTemplateMoney += '<input type="number" name="cost[discount]" id="e-cost-discount" class="form-control form-control-sm"';
    itemTemplateMoney += 'onchange="calculateCost();" value=""';
    itemTemplateMoney += '/>';
    itemTemplateMoney += '<div class="invalid-feedback"></div>';

    if(typeDiscount == 1){
        const compiledItemTemplate = _.template(itemTemplatePercent);
        $("#" + seccionId + " .c-section-discount").empty().append(compiledItemTemplate);
    } else {
        const compiledItemTemplate = _.template(itemTemplateMoney);
        $("#" + seccionId + " .c-section-discount").empty().append(compiledItemTemplate);
    }
}

function clearErrorInputs(sectionId){
    $("#" + sectionId + " form input, select, textarea").removeClass('is-invalid');
    $("#" + sectionId + " form input, select, textarea").next('.invalid-feedback').empty();
}

function recalculateTotal() {
    const totalPay = parseFloat($("#formHostingCompleted input[name='total_pay']").val());
    const extraSalesNotPaidTotal = parseFloat($("#formHostingCompleted input[name='extra_sales_not_paid_total']").val());
    let penalty = 0;
    if ($("#formHostingCompleted input[name='penalty']").val() !== '')
        penalty = parseFloat($("#formHostingCompleted input[name='penalty']").val());

    const newTotalPay = totalPay + penalty;
    const newTotal = newTotalPay + extraSalesNotPaidTotal;
    $("#formHostingCompleted input[name='total']").val(newTotal.toFixed(2));
    $("#bTotalPay").empty().text(newTotalPay.toFixed(2));
}
