class ClientInfoManager {
    constructor() {
        console.log('ClientInfoManager constructor called');
        this.baseTab = document.getElementById('base');
        this.clientIdInput = document.getElementById('client_id');
        this.setupValueChangeDetection();
    }

    setupValueChangeDetection() {
        if (!this.clientIdInput) return;

        // 値の変更を監視するためのカスタムプロパティを設定
        let storedValue = this.clientIdInput.value;
        Object.defineProperty(this.clientIdInput, 'value', {
            get: function() { return storedValue; },
            set: (value) => {
                storedValue = value;
                console.log('Client ID value changed to:', value);
                this.clientIdInput.setAttribute('value', value); // フォーム送信用に hidden input を更新
                if (value) {
                    this.fetchAndDisplayClientInfo(value);
                }
            }
        });
    }

    async fetchAndDisplayClientInfo(clientId) {
        if (!clientId) return;
        
        console.log('Attempting to fetch client info for ID:', clientId);

        try {
            const response = await fetch(`/api/client/${clientId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const responseText = await response.text();
            // console.log('Raw response:', responseText);

            if (responseText) {
                const data = JSON.parse(responseText);
                this.updateDisplay(data);
            }

        } catch (error) {
            console.error('Error fetching client info:', error);
            this.showError(error.message);
        }
    }

    updateDisplay(data) {
        // console.log('Updating display with data:', data);
    
        // 顧客名称、顧客種別、管轄事業部を更新
        const CorporationNumElement = this.baseTab.querySelector('.corporation-num');
        const CorporationNameElement = this.baseTab.querySelector('.corporation-name');
        const clientNumElement = this.baseTab.querySelector('.client-num');
        const clientNameElement = this.baseTab.querySelector('.client-name');
        const installationTypeElement = this.baseTab.querySelector('.installation-type');
        const clientTypeElement = this.baseTab.querySelector('.client-type');
        const affiliationElement = this.baseTab.querySelector('.affiliation');
        const salesUserElement = this.baseTab.querySelector('.sales-user');
        const tradeStatusElement = this.baseTab.querySelector('.trade-status');
        const telElement = this.baseTab.querySelector('.tel');
        const faxElement = this.baseTab.querySelector('.fax');

        const postalCodeElement = this.baseTab.querySelector('.postal-code');
        const prefectureElement = this.baseTab.querySelector('.prefecture');
        const addressElement = this.baseTab.querySelector('.address');

        if (CorporationNumElement) {
            CorporationNumElement.textContent = data.corporation?.corporation_num || '-';
        }
        if (CorporationNameElement) {
            CorporationNameElement.textContent = data.corporation?.corporation_name || '-';
        }
        if (clientNumElement) {
            clientNumElement.textContent = data.client_num || '-';
        }
        if (clientNameElement) {
            clientNameElement.textContent = data.client_name || '-';
        }
        if (installationTypeElement) {
            installationTypeElement.textContent = data.installation_type?.type_name || '-';
        }
        if (clientTypeElement) {
            clientTypeElement.textContent = data.client_type?.client_type_name || '-';
        }
        if (affiliationElement) {
            affiliationElement.textContent = data.affiliation2?.affiliation2_name || '-';
        }
        if (salesUserElement) {
            salesUserElement.textContent = data.user?.user_name || '-';
        }
        if (tradeStatusElement) {
            tradeStatusElement.textContent = data.trade_status?.trade_status_name || '-';
        }

        if (telElement) {
            telElement.textContent = data.head_tel || '-';
        }
        if (faxElement) {
            faxElement.textContent = data.head_fax || '-';
        }


        if (postalCodeElement) {
            postalCodeElement.textContent = data.postal_code || '-';
        }
        if (prefectureElement) {
            prefectureElement.textContent = data.prefecture?.prefecture_name || '-';
        }
        if (addressElement) {
            addressElement.textContent = data.head_address1 || '-';
        }

        // 導入システム情報の更新
        this.updateSystemTable(data.client_products || []); // client_products に変更
    }

    updateSystemTable(clientProducts) {  // 引数名を変更
        const tbody = document.querySelector('.system-table-body');
        if (!tbody) return;
    
        if (!clientProducts || clientProducts.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 border border-gray-300 dark:border-gray-500">導入システムはありません</td></tr>';
            return;
        }
    
        tbody.innerHTML = clientProducts.map(clientProduct => `
            <tr>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">
                    ${clientProduct.product?.product_series?.series_name || '-'}
                </td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">
                    ${clientProduct.product_version?.version_name || '-'}
                </td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">
                    ${clientProduct.product?.product_name || '-'}
                </td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">
                    ${clientProduct.is_customized ? '✔' : '-'}
                </td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">
                    ${clientProduct.is_contracted ? '✔' : '-'}
                </td>
                <td class="border border-gray-300 dark:border-gray-500 px-4 py-2 whitespace-nowrap text-sm">
                    ${clientProduct.quantity || '-'}
                </td>
            </tr>
        `).join('');
    }

    updateSection(sectionId, data) {
        Object.entries(data).forEach(([className, value]) => {
            const element = this.baseTab.querySelector(`.${className}`);
            if (element) {
                element.textContent = value || '-';
            }
        });
    }

    // updateContractsTable(contracts) {
    //     const tbody = this.baseTab.querySelector('.contracts-table tbody');
    //     if (!tbody) return;

    //     tbody.innerHTML = contracts.map(contract => `
    //         <tr>
    //             <td class="border border-gray-300 dark:border-gray-500 px-4 py-2">
    //                 ${contract.contract_type || '-'}
    //             </td>
    //             <td class="border border-gray-300 dark:border-gray-500 px-4 py-2">
    //                 ${this.formatCurrency(contract.contract_amount)}
    //             </td>
    //             <td class="border border-gray-300 dark:border-gray-500 px-4 py-2">
    //                 ${contract.contract_start_date || '-'}
    //             </td>
    //             <td class="border border-gray-300 dark:border-gray-500 px-4 py-2">
    //                 ${contract.contract_end_date || '-'}
    //             </td>
    //         </tr>
    //     `).join('');
    // }

    formatCurrency(amount) {
        return amount ? new Intl.NumberFormat('ja-JP').format(amount) : '-';
    }

    showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4';
        errorDiv.textContent = message;

        if (this.baseTab) {
            this.baseTab.insertBefore(errorDiv, this.baseTab.firstChild);
            setTimeout(() => errorDiv.remove(), 3000);
        }
    }
}

// DOMContentLoadedイベントで初期化
document.addEventListener('DOMContentLoaded', () => {
    console.log('Initializing ClientInfoManager');
    
    window.clientInfoManager = new ClientInfoManager();

    const clientIdInput = document.getElementById('client_id');
    const clientId = clientIdInput ? clientIdInput.value.trim() : '';

    if (clientId) {
        console.log('Restoring client info for ID:', clientId);
        window.clientInfoManager.fetchAndDisplayClientInfo(clientId);
    } else {
        console.warn('No client ID found for restoration.');
    }
});