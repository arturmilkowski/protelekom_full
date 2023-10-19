export function useTrueFalseMessage(field) {
  let message = ''
  const setMessage = () => {
    message = field === true ? 'Tak' : 'Nie'
  }
  setMessage()

  return { message }
}
