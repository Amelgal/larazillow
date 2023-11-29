import {computed, isRef} from 'vue'

export const useMonthlyPayment = ( total, interestRate, duration ) => {

  const getValue = (value) => {
    return isRef(value) ? value.value : value
  }

  const monthlyPayment = computed(() => {
    const principle = getValue(total)
    const monthlyInterest = getValue(interestRate) / 100 / 12
    const numberOfPaymentMonths = getValue(duration) * 12

    return principle * monthlyInterest * (Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) / (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
  })

  const totalPaid = computed(() => {
    return getValue(duration) * 12 * monthlyPayment.value
  })

  const totalInterest = computed(() => {
    return totalPaid.value - getValue(total)
  })

  return { monthlyPayment, totalPaid, totalInterest }
}

