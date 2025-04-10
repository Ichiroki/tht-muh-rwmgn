// Dropdown
const toggleDropdown = (id) => {
    const dropdown = document.getElementById(id)
    dropdown.style.display = dropdown.style.display === "flex" ? 'none' : 'flex'
}

// Input Anggaran
const inputAnggaran = document.getElementById('anggaran')

inputAnggaran.addEventListener('input', function(e) {
    let rawValue = this.value.replace(/\D/g, '')
    
    if(rawValue) {
        this.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(rawValue)
    } else {
        this.value = ''
    }
})