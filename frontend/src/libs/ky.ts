import kyLib from 'ky-universal'

export const ky = kyLib.create({
  prefixUrl:
    process.env.NODE_ENV === 'production'
      ? 'https://api.prtimes-hackathon.ky-y.app/'
      : 'http://localhost/',
  credentials: 'include',
})
