/**
 * Ocean Container Freight Rate Calculator
 * Calculates detailed pricing for overseas shipments
 */

const OceanFreightCalculator = {
    // Base rates for container types by commodity
    baseRates: {
        'household_goods': {
            '20_dry': 1867.00,
            '40_dry': 2950.00,
            '40_high_cube': 3150.00
        },
        'commercial': {
            '20_dry': 1650.00,
            '40_dry': 2750.00,
            '40_high_cube': 2950.00
        },
        'cars_only': {
            '20_dry': 1500.00,
            '40_dry': 2500.00,
            '40_high_cube': 2700.00
        }
    },

    // BAF (Bunker Adjustment Factor) rates
    bafRates: {
        '20_dry': 190.00,
        '40_dry': 290.00,
        '40_high_cube': 320.00
    },

    // Fixed charges
    fixedCharges: {
        billOfLading: 50.00,
        terminalHandling: 150.00,
        residentialPickup: 400.00,
        personalEffectsSurcharge: 400.00,
        customsBrokerage: 550.00
    },

    // Distance-based pickup charges (in miles)
    pickupCharges: {
        '0-10': 150.00,
        '11-25': 280.00,
        '26-50': 520.00,
        '51-100': 1220.00,
        '101-200': 1850.00,
        '201+': 2500.00
    },

    // Distance-based delivery charges (in miles)
    deliveryCharges: {
        '0-10': 280.00,
        '11-25': 420.00,
        '26-50': 680.00,
        '51-100': 1350.00,
        '101-200': 2100.00,
        '201+': 2800.00
    },

    /**
     * Calculate total freight cost
     */
    calculateFreight(formData) {
        const breakdown = [];
        let total = 0;

        const containerType = formData.container_type;
        const commodityType = formData.commodity_type;
        const weight = parseFloat(formData.cargo_weight) || 0;
        const declaredValue = parseFloat(formData.insurance_value) || 0;

        // 1. Base Freight Charge
        const baseRate = this.baseRates[commodityType]?.[containerType] || 0;
        if (baseRate > 0) {
            breakdown.push({
                description: `Freight (${this.getCommodityLabel(commodityType)})`,
                value: this.getContainerLabel(containerType),
                rate: baseRate,
                qty: 1,
                amount: baseRate
            });
            total += baseRate;
        }

        // 2. BAF Charges
        const bafRate = this.bafRates[containerType] || 0;
        if (bafRate > 0) {
            breakdown.push({
                description: 'Bunker Adjustment Factor [BAF Charges]',
                value: this.getContainerLabel(containerType),
                rate: bafRate,
                qty: 1,
                amount: bafRate
            });
            total += bafRate;
        }

        // 3. Wharfage (based on weight)
        const weightMT = weight * 0.000453592; // Convert lbs to metric tons
        const wharfageRate = 2.00;
        const wharfageAmount = Math.max(2.00, weightMT * wharfageRate);
        breakdown.push({
            description: 'Wharfage',
            value: `${weightMT.toFixed(2)} MT`,
            rate: wharfageRate,
            qty: '',
            amount: wharfageAmount
        });
        total += wharfageAmount;

        // 4. Bill of Lading
        breakdown.push({
            description: 'Bill Of Lading',
            value: '',
            rate: '',
            qty: '',
            amount: this.fixedCharges.billOfLading
        });
        total += this.fixedCharges.billOfLading;

        // 5. Terminal Handling Charges
        breakdown.push({
            description: 'Terminal Handling Charges',
            value: '',
            rate: '',
            qty: '',
            amount: this.fixedCharges.terminalHandling
        });
        total += this.fixedCharges.terminalHandling;

        // 6. Residential Pickup (if household goods)
        if (commodityType === 'household_goods') {
            breakdown.push({
                description: 'Residential Pickup Charges',
                value: '',
                rate: '',
                qty: '',
                amount: this.fixedCharges.residentialPickup
            });
            total += this.fixedCharges.residentialPickup;
        }

        // 7. Personal Effects Surcharge (if household goods)
        if (commodityType === 'household_goods') {
            breakdown.push({
                description: 'Surcharge for Personal Effects (with or without Cars)',
                value: '',
                rate: '',
                qty: '',
                amount: this.fixedCharges.personalEffectsSurcharge
            });
            total += this.fixedCharges.personalEffectsSurcharge;
        }

        // 8. Drayage (pickup distance-based) - using default 51-100 miles if not specified
        const pickupDistance = formData.pickup_distance || '51-100';
        const drayageAmount = this.pickupCharges[pickupDistance] || this.pickupCharges['51-100'];
        breakdown.push({
            description: `Drayage to Loading Area\n(${this.getDistanceLabel(pickupDistance)})`,
            value: '',
            rate: drayageAmount,
            qty: 1,
            amount: drayageAmount
        });
        total += drayageAmount;

        // 9. Fuel Surcharge (40% of drayage)
        const fuelSurcharge = drayageAmount * 0.40;
        breakdown.push({
            description: 'Fuel Surcharge',
            value: '',
            rate: '',
            qty: '',
            amount: fuelSurcharge
        });
        total += fuelSurcharge;

        // 10. Customs Brokerage (if selected)
        if (formData.overseas_customs === 'yes') {
            breakdown.push({
                description: 'Customs Brokerage Fee',
                value: '',
                rate: '',
                qty: '',
                amount: this.fixedCharges.customsBrokerage
            });
            total += this.fixedCharges.customsBrokerage;
        }

        // 11. Delivery Charges (if selected)
        if (formData.overseas_delivery === 'yes') {
            const deliveryDistance = formData.delivery_distance || '0-10';
            const deliveryAmount = this.deliveryCharges[deliveryDistance] || this.deliveryCharges['0-10'];
            breakdown.push({
                description: `Delivery Charges (${this.getDistanceLabel(deliveryDistance)})`,
                value: '',
                rate: deliveryAmount,
                qty: 1,
                amount: deliveryAmount
            });
            total += deliveryAmount;
        }

        // 12. Insurance (if selected and value provided)
        if (formData.overseas_insurance === 'yes' && declaredValue > 0) {
            const insuranceRate = 3.5; // 3.5%
            const insuranceAmount = (declaredValue * insuranceRate) / 100;
            breakdown.push({
                description: `Insurance Charges ($500 Deductible)\n(Type Of Goods: ${this.getCommodityLabel(commodityType)})`,
                value: `$${declaredValue.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`,
                rate: `${insuranceRate} %`,
                qty: '',
                amount: insuranceAmount
            });
            total += insuranceAmount;
        }

        // 13. Shipper's Declaration (if value over $2,500)
        if (declaredValue > 2500) {
            breakdown.push({
                description: "Shipper's Declaration (Over $2,500.00)",
                value: `$${declaredValue.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`,
                rate: '',
                qty: '',
                amount: 50.00
            });
            total += 50.00;
        }

        return {
            breakdown: breakdown,
            total: total,
            weight: weight,
            weightKg: (weight * 0.453592).toFixed(1),
            origin: formData.overseas_pickup_port,
            destination: formData.overseas_destination_port
        };
    },

    /**
     * Helper functions
     */
    getContainerLabel(type) {
        const labels = {
            '20_dry': "20' Container",
            '40_dry': "40' Container",
            '40_high_cube': "40' High Cube"
        };
        return labels[type] || type;
    },

    getCommodityLabel(type) {
        const labels = {
            'household_goods': 'HOUSEHOLD GOODS',
            'commercial': 'COMMERCIAL ITEMS',
            'cars_only': 'CARS ONLY'
        };
        return labels[type] || type.toUpperCase();
    },

    getDistanceLabel(range) {
        const labels = {
            '0-10': '1 - 10 Miles',
            '11-25': '11 - 25 Miles',
            '26-50': '26 - 50 Miles',
            '51-100': '51 - 100 Miles',
            '101-200': '101 - 200 Miles',
            '201+': 'Over 200 Miles'
        };
        return labels[range] || range;
    }
};

// Make it globally available
window.OceanFreightCalculator = OceanFreightCalculator;
