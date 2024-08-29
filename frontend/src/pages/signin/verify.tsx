import {
  Container,
  Box,
  Typography,
  TextField,
  Button,
  CssBaseline,
  Paper,
} from '@mui/material'
import { createTheme, ThemeProvider } from '@mui/material/styles'
import { useRouter } from 'next/router'
import React from 'react'
import { ky } from '@/libs/ky'

const theme = createTheme()

export default function LoginForm() {
  const router = useRouter()

  const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    const data = new FormData(event.currentTarget)

    ky.post('./api/signin/verify', {
      json: {
        token: data.get('otp'),
      },
    })
      .then(() => {
        router.push('/home').then()
      })
      .catch(async (reason) => {
        const error = (await reason.response.json()) as {
          status: string
          type: string
          message: string
          data: { [key: string]: string[] }
        }
        const message = Object.keys(error.data)
          .map((key) => {
            return error.data[key].join(' ')
          })
          .join('\n')
        alert(error.message + '\n\n' + message)
      })
  }

  return (
    <ThemeProvider theme={theme}>
      <Container component="main" maxWidth="xs">
        <CssBaseline />
        <Paper
          elevation={3}
          sx={{
            marginTop: 8,
            padding: 4,
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',
          }}
        >
          <Typography component="h1" variant="h5">
            メールアドレスに届いたワンタイムパスワードを入力してください
          </Typography>
          <Box
            component="form"
            onSubmit={handleSubmit}
            noValidate
            sx={{ mt: 1 }}
          >
            <TextField
              margin="normal"
              required
              fullWidth
              id="otp"
              label="ワンタイムパスワード（数字六桁）"
              name="otp"
              type="number"
            />
            <Button
              type="submit"
              fullWidth
              variant="contained"
              sx={{ mt: 3, mb: 2 }}
            >
              認証
            </Button>
          </Box>
        </Paper>
      </Container>
    </ThemeProvider>
  )
}
