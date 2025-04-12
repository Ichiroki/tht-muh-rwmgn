// Dropdown
const toggleDropdown = (id) => {
    const dropdown = document.getElementById(id)
    dropdown.style.display = dropdown.style.display === "flex" ? 'none' : 'flex'
}

// Input Amount
const inputAmount = document.getElementById('amount')

if(inputAmount) {
    inputAmount.addEventListener('input', function(e) {
        let rawValue = this.value.replace(/\D/g, '')
        
        if(rawValue) {
            this.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(rawValue)
        } else {
            this.value = ''
        }
    })
}